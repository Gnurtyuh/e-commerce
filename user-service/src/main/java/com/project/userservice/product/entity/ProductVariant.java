package com.project.userservice.product.entity;


import jakarta.persistence.*;
import lombok.*;
import lombok.experimental.FieldDefaults;

import java.math.BigDecimal;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@Table(name ="product_variants")
@Entity
@Builder
public class ProductVariant {
    @Id
    @Column(name = "variant_id", nullable = false, updatable = false)
    @GeneratedValue
    Long variantId ;
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "product_id", nullable = false)
    Product product;
    @Column(name = "sku")
    String sku ;
    @Column(name = "price")
    BigDecimal price;
    @Column(name = "stock")
    Long stock;
}
