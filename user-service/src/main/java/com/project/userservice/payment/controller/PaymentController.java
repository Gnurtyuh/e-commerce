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

@RestController
@RequestMapping("/payments")
@RequiredArgsConstructor
@Tag(name = "Payment API", description = "Thanh toán đơn hàng")
public class PaymentController {

    private final PaymentService paymentService;


    @PostMapping
    @Operation(summary = "Thanh toán đơn hàng")
    public ResponseEntity<PaymentResponse> createPayment(
            @RequestBody PaymentRequest request
    ) {
        return ResponseEntity.ok(paymentService.create(request));
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
}