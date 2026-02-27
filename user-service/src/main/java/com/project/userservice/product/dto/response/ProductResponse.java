package com.project.userservice.product.dto.response;

import lombok.*;
import lombok.experimental.FieldDefaults;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class ProductResponse {
    private Long productId;
    private Long categoryId;
    private String name;
    private String description;
    private String status;
}
