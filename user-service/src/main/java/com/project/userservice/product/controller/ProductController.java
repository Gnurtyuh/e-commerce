package com.project.userservice.product.controller;

import com.project.userservice.product.dto.request.ProductRequest;
import com.project.userservice.product.dto.response.ProductResponse;
import com.project.userservice.product.service.ProductService;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.util.List;

@RestController
@RequestMapping("/products")
@FieldDefaults(level = AccessLevel.PRIVATE, makeFinal = true)
@RequiredArgsConstructor
public class ProductController {
    ProductService productService;
    @PostMapping
    public ResponseEntity<ProductResponse> create(@RequestBody ProductRequest dto) {
        var result = productService.create(dto);
        return ResponseEntity
                .created(URI.create("/products/"+result.getProductId()))
                .body(result);
    }
    @PutMapping("/{productId}")
    public ResponseEntity<ProductResponse> update(@PathVariable Long productId, @RequestBody ProductRequest dto) {
        var result = productService.update(productId, dto);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/{productId}")
    public ResponseEntity<ProductResponse> get(@PathVariable Long productId) {
        var result = productService.get(productId);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping
    public ResponseEntity<List<ProductResponse>> getAll() {
        var result = productService.findAll();
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/by-category/{categoryId}")
    public ResponseEntity<List<ProductResponse>> getAllByCategory(@PathVariable Long categoryId) {
        var result = productService.findByCategoryId(categoryId);
        return ResponseEntity.ok().body(result);
    }
    @DeleteMapping("/{productId}")
    public ResponseEntity<Void> delete(@PathVariable Long productId) {
        productService.delete(productId);
        return ResponseEntity.noContent().build();
    }
}
