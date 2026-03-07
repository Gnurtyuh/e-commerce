package com.project.userservice.payment.service;

import com.project.userservice.order.entity.Order;
import com.project.userservice.order.repository.OrderRepository;
import com.project.userservice.payment.dto.request.PaymentRequest;
import com.project.userservice.payment.dto.response.PaymentResponse;
import com.project.userservice.payment.entity.Payment;
import com.project.userservice.payment.mapper.PaymentMapper;
import com.project.userservice.payment.repository.PaymentRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;
import java.util.List;

@Service
@RequiredArgsConstructor
@Transactional
public class PaymentService {

    private final PaymentRepository paymentRepository;
    private final OrderRepository orderRepository;


    public PaymentResponse create(PaymentRequest request) {

        Order order = orderRepository.findById(request.getOrderId())
                .orElseThrow(() -> new RuntimeException("Order not found"));

        // 1. Không cho thanh toán lại
        if ("PAID".equals(order.getStatus())) {
            throw new RuntimeException("Order already paid");
        }

        // 2. Check số tiền
        if (order.getTotalAmount().compareTo(request.getAmount()) != 0) {
            throw new RuntimeException("Invalid payment amount");
        }

        // 3. Tạo payment
        Payment payment = new Payment();
        payment.setOrder(order);
        payment.setAmount(request.getAmount());
        payment.setStatus("SUCCESS");
        payment.setPaidAt(LocalDateTime.now());

        // 4. Update order status
        order.setStatus("PAID");

        return PaymentMapper.toResponse(paymentRepository.save(payment));
    }


    @Transactional(readOnly = true)
    public List<PaymentResponse> getPaymentsByOrder(Long orderId) {

        return paymentRepository.findByOrder_OrderId(orderId)
                .stream()
                .map(PaymentMapper::toResponse)
                .toList();
    }
}