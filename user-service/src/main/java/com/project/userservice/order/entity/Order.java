package com.project.userservice.order.entity;

import jakarta.persistence.*;
import lombok.*;
import lombok.experimental.FieldDefaults;

import java.math.BigDecimal;
import java.time.LocalDateTime;
import java.util.List;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@Table(name ="orders")
@Entity
@Builder
public class Order {
    @Id
    @Column(name = "order_id", nullable = false, updatable = false)
    @GeneratedValue
    Long orderId ;
    @Column(name = "user_id")
    Long userId;
    @Column(name = "total_amount", nullable = false, precision = 12, scale = 2)
    BigDecimal totalAmount;
    @Column(name = "status")
    String status ;
    @Column(name = "created_at")
    LocalDateTime createdAt = LocalDateTime.now();
    @OneToMany(
            mappedBy = "order",
            cascade = CascadeType.ALL,
            orphanRemoval = true,
            fetch = FetchType.LAZY
    )
    private List<OrderItem> items;

    /* ===== lifecycle ===== */
    @PrePersist
    public void prePersist() {
        this.createdAt = LocalDateTime.now();
    }
}
