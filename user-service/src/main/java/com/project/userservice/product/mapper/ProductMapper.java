package com.project.userservice.product.mapper;

import com.project.userservice.product.dto.request.ProductRequest;
import com.project.userservice.product.dto.response.ProductResponse;
import com.project.userservice.product.entity.Product;
import org.springframework.stereotype.Component;

@Component
public class ProductMapper {

    public static ProductResponse toResponse(Product entity) {
        ProductResponse dto = new ProductResponse();
        dto.setProductId(entity.getProductId());
        dto.setCategoryId(entity.getCategoryId());
        dto.setName(entity.getName());
        dto.setDescription(entity.getDescription());
        dto.setStatus(entity.getStatus());
        return dto;
    }
    public static Product  toEntity(ProductRequest dto) {
        Product entity = new Product();
        entity.setCategoryId(dto.getCategoryId());
        entity.setName(dto.getName());
        entity.setDescription(dto.getDescription());
        entity.setStatus(dto.getStatus());
        return entity;
    }
}
