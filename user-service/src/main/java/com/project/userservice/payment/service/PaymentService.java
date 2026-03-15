package com.project.userservice.payment.service;

import com.project.userservice.order.entity.Order;
import com.project.userservice.order.repository.OrderRepository;
import com.project.userservice.payment.dto.request.PaymentRequest;
import com.project.userservice.payment.dto.response.PaymentResponse;
import com.project.userservice.payment.entity.Payment;
import com.project.userservice.payment.mapper.PaymentMapper;
import com.project.userservice.payment.repository.PaymentRepository;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import vn.payos.PayOS;
import vn.payos.model.v2.paymentRequests.CreatePaymentLinkRequest;


import java.time.LocalDateTime;
import java.util.List;
import java.util.Map;
@Slf4j
@Service
@RequiredArgsConstructor
@Transactional
public class PaymentService {

    private final PaymentRepository paymentRepository;
    private final OrderRepository orderRepository;
    private final PayOS payOS;

    public String create(Long orderId) throws Exception {

        Order order = orderRepository.findById(orderId)
                .orElseThrow(() -> new RuntimeException("Order not found"));

        long orderCode = System.currentTimeMillis();


        // 3. Tạo payment
        Payment payment = new Payment();
        payment.setOrder(order);
        payment.setAmount(order.getTotalAmount());
        payment.setStatus("PENDING");
        payment.setPaidAt(LocalDateTime.now());
        payment.setOrderCode(orderCode);
        paymentRepository.save(payment);

        CreatePaymentLinkRequest paymentRequest = CreatePaymentLinkRequest.builder()
                .orderCode(orderCode)
                .amount((long) order.getTotalAmount().intValue())
                .description("Order" + orderId)
                .returnUrl("http://localhost:3000/payment-success")
                .cancelUrl("http://localhost:3000/cart")
                .build();

        var paymentLink = payOS.paymentRequests().create(paymentRequest);

        return paymentLink.getCheckoutUrl();
    }


    @Transactional(readOnly = true)
    public List<PaymentResponse> getPaymentsByOrder(Long orderId) {

        return paymentRepository.findByOrder_OrderId(orderId)
                .stream()
                .map(PaymentMapper::toResponse)
                .toList();
    }
    public boolean verifyPayment(Map<String, Object> paymentData) {
        try {
            Long orderCode = Long.valueOf(paymentData.get("orderCode").toString());
            String status = paymentData.get("status").toString();

            Payment payment = paymentRepository.findByOrderCode(orderCode)
                    .orElseThrow(() -> new RuntimeException("Payment not found"));

            // Chỉ cập nhật nếu đang PENDING
            if ("PENDING".equals(payment.getStatus())) {
                payment.setStatus(status);
                if ("PAID".equals(status)) {
                    payment.setPaidAt(LocalDateTime.now());

                    // Cập nhật order
                    Order order = payment.getOrder();
                    order.setStatus("PAID");
                    orderRepository.save(order);
                }
                paymentRepository.save(payment);
                log.info("Payment verified for orderCode: {} with status: {}", orderCode, status);
            }

            return true;
        } catch (Exception e) {
            log.error("Verify payment error: ", e);
            return false;
        }
    }

    // THÊM METHOD NÀY
    public PaymentResponse getPaymentByOrderCode(Long orderCode) {
        Payment payment = paymentRepository.findByOrderCode(orderCode)
                .orElseThrow(() -> new RuntimeException("Payment not found"));
        return PaymentMapper.toResponse(payment);
    }
}