package com.project.userservice.product.entity;

import jakarta.persistence.*;
import lombok.*;
import lombok.experimental.FieldDefaults;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@Table(name ="products")
@Entity
@Builder
public class Product {
    @Id
    @Column(name = "product_id", nullable = false, updatable = false)
    @GeneratedValue
    Long productId ;
    @Column(name = "category_id")
    Long categoryId;
    @Column(name = "name")
    String name ;
    @Column(name = "description")
    String description ;
    @Column(name = "status")
    String status;
}
