package com.project.userservice.product.dto.response;

import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDateTime;

@Data
@AllArgsConstructor
@NoArgsConstructor
@Builder
public class ProductImageResponse {
    private Long imageId;
    private Long productId;
    private String imagePath;
    private Boolean isMain;
    private Integer sortOrder;
    private LocalDateTime createdAt;
}
