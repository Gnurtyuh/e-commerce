package com.project.userservice.product.dto.request;

import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
@Builder
public class ProductImageRequest {
    private String imagePath;
    private Boolean isMain;
    private Integer sortOrder;
}
