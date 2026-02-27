package com.project.userservice.category.mapper;

import com.project.userservice.category.dto.request.CategoryRequest;
import com.project.userservice.category.dto.response.CategoryResponse;
import com.project.userservice.category.entity.Category;
import org.springframework.stereotype.Component;

@Component
public class CategoryMapper {

    public static CategoryResponse toResponse(Category entity) {
        CategoryResponse dto = new CategoryResponse();
        dto.setCategoryId(entity.getCategoryId());
        dto.setName(entity.getName());
        dto.setParentId( entity.getParentId());
        return dto;
    }
    public static Category toEntity(CategoryRequest dto) {
        Category entity = new Category();
        entity.setName(dto.getName());
        entity.setParentId(dto.getParentId());
        return entity;
    }
}