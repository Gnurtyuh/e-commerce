package com.project.userservice.product.dto.response;

import lombok.*;
import lombok.experimental.FieldDefaults;

import java.math.BigDecimal;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class ProductVariantResponse {
    private Long variantId;
    private Long productId;
    private String sku;
    private BigDecimal price;
    private Long stock;
}
