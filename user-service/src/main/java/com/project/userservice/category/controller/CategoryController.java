package com.project.userservice.category.controller;

import com.project.userservice.category.dto.request.CategoryRequest;
import com.project.userservice.category.dto.response.CategoryResponse;
import com.project.userservice.category.mapper.CategoryMapper;
import com.project.userservice.category.service.CategoryService;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.util.List;

@RestController
@RequestMapping("/categories")
@FieldDefaults(level = AccessLevel.PRIVATE,makeFinal = true)
@RequiredArgsConstructor
public class CategoryController {
    CategoryService categoryService;
    @PostMapping
    public ResponseEntity<CategoryResponse> create(@RequestBody CategoryRequest category) {
        var result =  categoryService.create(category);
        return ResponseEntity
                .created(URI.create("/categories/" + result.getCategoryId()))
                .body(result);
    }
    @PutMapping("/{categoryId}")
    public ResponseEntity<CategoryResponse> update(@PathVariable Long categoryId, @RequestBody CategoryRequest category) {
        var result = categoryService.update(categoryId,category);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/{categoryId}")
    public ResponseEntity<CategoryResponse> get(@PathVariable Long categoryId) {
        var result = categoryService.get(categoryId);
        return ResponseEntity.ok(result);
    }
    @GetMapping()
    public ResponseEntity<List<CategoryResponse>> getAll() {
        var result = categoryService.getAll();
        return ResponseEntity.ok().body(result);
    }
    @DeleteMapping("/{categoryId}")
    public ResponseEntity<Void> delete(@PathVariable Long categoryId) {
        categoryService.delete(categoryId);
        return ResponseEntity.noContent().build();
    }
}
