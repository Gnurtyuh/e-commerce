package com.project.userservice.payment.controller;

import com.project.userservice.payment.dto.request.PaymentRequest;
import com.project.userservice.payment.dto.response.PaymentResponse;
import com.project.userservice.payment.service.PaymentService;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/payments")
@RequiredArgsConstructor
@Tag(name = "Payment API", description = "Thanh toán đơn hàng")
public class PaymentController {

    private final PaymentService paymentService;


    @PostMapping("/create/{orderId}")
    @Operation(summary = "Thanh toán đơn hàng")
    public ResponseEntity<?> createPayment(
            @PathVariable Long orderId
    ) throws Exception {
        return ResponseEntity.ok(paymentService.create(orderId));
    }


    @GetMapping("/orders/{orderId}")
    @Operation(summary = "Lấy danh sách thanh toán theo order")
    public ResponseEntity<List<PaymentResponse>> getPaymentsByOrder(
            @PathVariable Long orderId
    ) {
        return ResponseEntity.ok(
                paymentService.getPaymentsByOrder(orderId)
        );
    }
    @PostMapping("/verify")
    @Operation(summary = "Xác thực thanh toán")
    public ResponseEntity<?> verifyPayment(@RequestBody Map<String, Object> paymentData) {
        try {
            boolean verified = paymentService.verifyPayment(paymentData);
            return ResponseEntity.ok(Map.of(
                    "success", verified,
                    "message", verified ? "Xác thực thành công" : "Xác thực thất bại"
            ));
        } catch (Exception e) {
            return ResponseEntity.badRequest().body(Map.of(
                    "success", false,
                    "message", e.getMessage()
            ));
        }
    }

    // THÊM API NÀY - Lấy trạng thái payment theo orderCode
    @GetMapping("/status/{orderCode}")
    @Operation(summary = "Lấy trạng thái thanh toán")
    public ResponseEntity<?> getPaymentStatus(@PathVariable Long orderCode) {
        try {
            PaymentResponse payment = paymentService.getPaymentByOrderCode(orderCode);
            return ResponseEntity.ok(payment);
        } catch (Exception e) {
            return ResponseEntity.badRequest().body(Map.of(
                    "success", false,
                    "message", e.getMessage()
            ));
        }
    }
}