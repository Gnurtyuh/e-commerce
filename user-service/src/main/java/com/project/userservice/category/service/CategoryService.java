package com.project.userservice.category.service;

import com.project.userservice.category.dto.request.CategoryRequest;
import com.project.userservice.category.dto.response.CategoryResponse;
import com.project.userservice.category.entity.Category;
import com.project.userservice.category.mapper.CategoryMapper;
import com.project.userservice.category.repository.CategoryRepository;
import jakarta.transaction.Transactional;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.stream.Collectors;

@Service
@RequiredArgsConstructor
@FieldDefaults(level = AccessLevel.PRIVATE, makeFinal = true)
public class CategoryService {
    CategoryRepository categoryRepository;
    @Transactional
    public CategoryResponse create(CategoryRequest dto) {
        Category category =categoryRepository.save(CategoryMapper.toEntity(dto));
        return  CategoryMapper.toResponse(category);
    }
    @Transactional
    public CategoryResponse update(Long categoryId ,CategoryRequest dto) {
        Category category = categoryRepository.findById(categoryId).orElseThrow(() -> new RuntimeException("Category not found"));
        category.setName(dto.getName());
        category.setParentId(dto.getParentId());
        categoryRepository.save(category);
        return CategoryMapper.toResponse(category);
    }
    public void delete(Long categoryId) {
        categoryRepository.deleteById(categoryId);
    }
    public CategoryResponse get(Long categoryId) {
        return categoryRepository.findById(categoryId).map(CategoryMapper::toResponse).orElse(null);
    }
    public List<CategoryResponse> getAll() {
        return categoryRepository.findAll().stream().map(CategoryMapper::toResponse).collect(Collectors.toList());
    }
}
