package com.project.userservice.product.controller;

import com.project.userservice.product.dto.request.ProductRequest;
import com.project.userservice.product.dto.response.ProductResponse;
import com.project.userservice.product.service.ProductService;
import lombok.AccessLevel;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.util.List;

@RestController
@RequestMapping("/product")
@FieldDefaults(level = AccessLevel.PRIVATE)
public class ProductController {
    @Autowired
    ProductService productService;
    @PostMapping("/products")
    public ResponseEntity<ProductResponse> create(@RequestBody ProductRequest dto) {
        var result = productService.create(dto);
        return ResponseEntity
                .created(URI.create("product/products"+result.getProductId()))
                .body(result);
    }
    @PutMapping("/products/{productId}")
    public ResponseEntity<ProductResponse> update(@PathVariable Long productId, @RequestBody ProductRequest dto) {
        var result = productService.update(productId, dto);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/products/{productId}")
    public ResponseEntity<ProductResponse> get(@PathVariable Long productId) {
        var result = productService.get(productId);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/products")
    public ResponseEntity<List<ProductResponse>> getAll() {
        var result = productService.findAll();
        return ResponseEntity.ok().body(result);
    }
    @DeleteMapping("/products/{productId}")
    public ResponseEntity<Void> delete(@PathVariable Long productId) {
        productService.delete(productId);
        return ResponseEntity.noContent().build();
    }
}
