package com.project.userservice.payment.repository;

import com.project.userservice.payment.entity.Payment;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public interface PaymentRepository extends JpaRepository<Payment, Long> {
    @Query("select p from Payment p where p.order.orderId = :order_id and p.status = 'PAID' ")
    Payment findByOrder_OrderId(@Param("order_id") Long orderId);
    Optional<Payment> findByOrderCode(Long orderCode);
}
