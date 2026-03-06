package com.project.userservice.payment.mapper;

import com.project.userservice.payment.dto.response.PaymentResponse;
import com.project.userservice.payment.entity.Payment;

public class PaymentMapper {

    public static PaymentResponse toResponse(Payment payment) {
        PaymentResponse res = new PaymentResponse();
        res.setPaymentId(payment.getPaymentId());
        res.setOrderId(payment.getOrder().getOrderId());
        res.setAmount(payment.getAmount());
        res.setStatus(payment.getStatus());
        res.setPaidAt(payment.getPaidAt());
        return res;
    }
}