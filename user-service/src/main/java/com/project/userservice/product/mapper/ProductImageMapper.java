package com.project.userservice.product.mapper;

import com.project.userservice.product.dto.response.ProductImageResponse;
import com.project.userservice.product.entity.ProductImage;

public class ProductImageMapper {
    public static ProductImageResponse toResponse(ProductImage entity) {
        ProductImageResponse res = new ProductImageResponse();
        res.setImageId(entity.getImageId());
        res.setProductId(entity.getProductId());
        res.setImagePath(entity.getImagePath());
        res.setIsMain(entity.getIsMain());
        res.setSortOrder(entity.getSortOrder());
        res.setCreatedAt(entity.getCreatedAt());
        return res;
    }
}
