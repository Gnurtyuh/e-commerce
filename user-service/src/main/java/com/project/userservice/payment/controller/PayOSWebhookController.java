package com.project.userservice.payment.controller;

import com.project.userservice.order.entity.Order;
import com.project.userservice.order.repository.OrderRepository;
import com.project.userservice.payment.entity.Payment;
import com.project.userservice.payment.repository.PaymentRepository;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import vn.payos.PayOS;
import vn.payos.model.webhooks.Webhook;

import java.time.LocalDateTime;
import java.util.Map;

@Slf4j
@RestController
@RequestMapping("/payos")
@RequiredArgsConstructor
public class PayOSWebhookController {

    private final PaymentRepository paymentRepository;
    private final OrderRepository orderRepository;
    private final PayOS payOS;

    @PostMapping("/webhook")
    public ResponseEntity<?> handleWebhook(@RequestBody Webhook webhook) {
        try {
            log.info("Received webhook from PayOS: {}", webhook);

            // Xác thực webhook data
            var data = payOS.webhooks().verify(webhook);


            // Kiểm tra signature và dữ liệu
            if (webhook.getSuccess() && data != null) {

                // Tìm payment theo orderCode
                Payment payment = paymentRepository.findByOrderCode(data.getOrderCode())
                        .orElseThrow(() -> new RuntimeException("Payment not found with orderCode: " + data.getOrderCode()));

                // Kiểm tra nếu payment đã được xử lý rồi thì không xử lý lại
                if (!"PENDING".equals(payment.getStatus())) {
                    log.info("Payment already processed with status: {}", payment.getStatus());
                    return ResponseEntity.ok(Map.of(
                            "success", true,
                            "message", "Payment already processed"
                    ));
                }

                // PayOS trả về code "00" là thành công
                String status = "00".equals(data.getCode()) ? "PAID" : "FAILED";
                payment.setStatus(status);

                if ("00".equals(data.getCode())) {
                    payment.setPaidAt(LocalDateTime.now());
                    // Cập nhật order thành PAID
                    Order order = payment.getOrder();
                    order.setStatus("PAID");
                    orderRepository.save(order);
                    log.info("Order {} updated to PAID", order.getOrderId());
                } else {
                    // Cập nhật order thành PENDING hoặc FAILED tùy logic
                    Order order = payment.getOrder();
                    order.setStatus("PENDING");
                    orderRepository.save(order);
                }

                paymentRepository.save(payment);

                log.info("Payment updated successfully for orderCode: {} with status: {}",
                        data.getOrderCode(), status);

                return ResponseEntity.ok(Map.of(
                        "success", true,
                        "message", "Webhook processed successfully"
                ));
            }

            log.warn("Invalid webhook signature or data");
            return ResponseEntity.badRequest().body(Map.of(
                    "success", false,
                    "message", "Invalid signature or data"
            ));

        } catch (Exception e) {
            log.error("Error processing webhook: ", e);
            return ResponseEntity.badRequest().body(Map.of(
                    "success", false,
                    "message", e.getMessage()
            ));
        }
    }
}