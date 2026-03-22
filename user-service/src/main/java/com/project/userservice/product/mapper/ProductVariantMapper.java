package com.project.userservice.product.mapper;

import com.project.userservice.product.dto.request.ProductVariantRequest;
import com.project.userservice.product.dto.response.ProductVariantResponse;
import com.project.userservice.product.entity.Product;
import com.project.userservice.product.entity.ProductVariant;
import org.springframework.stereotype.Component;

@Component
public class ProductVariantMapper {
    public static ProductVariantResponse toResponse(ProductVariant entity) {
        ProductVariantResponse dto = new ProductVariantResponse();
        dto.setVariantId(entity.getVariantId());
        dto.setProductId( entity.getProduct() != null
                ? entity.getProduct().getProductId()
                : null);
        dto.setSku(entity.getSku());
        dto.setStock(entity.getStock());
        dto.setPrice(entity.getPrice());
        return dto;
    }
    public static ProductVariant toEntity(ProductVariantRequest dto, Product product) {
        ProductVariant entity = new ProductVariant();
        entity.setStock(dto.getStock());
        entity.setSku(dto.getSku());
        entity.setPrice(dto.getPrice());
        entity.setProduct(product);
        return entity;
    }
}
