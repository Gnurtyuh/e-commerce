package com.project.userservice.product.controller;
import com.project.userservice.product.dto.request.ProductVariantRequest;
import com.project.userservice.product.dto.response.ProductVariantResponse;
import com.project.userservice.product.mapper.ProductVariantMapper;
import com.project.userservice.product.service.ProductVariantService;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.util.List;

@RestController
@FieldDefaults(level = AccessLevel.PRIVATE)
@RequiredArgsConstructor
public class ProductVariantController {
    final ProductVariantService productVariantService;
    @PostMapping("/products/{productId}/variants")
    public ResponseEntity<ProductVariantResponse> create(@PathVariable Long productId, @RequestBody ProductVariantRequest dto) {
        var result = productVariantService.create(productId,dto);
        return ResponseEntity
                .created(URI.create("/variants/"+result.getVariantId()))
                .body(result);
    }
    @PutMapping("/variants/{variantId}")
    public ResponseEntity<ProductVariantResponse> update(@PathVariable Long variantId, @RequestBody ProductVariantRequest dto) {
        var result = productVariantService.update(variantId, dto);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/variants/{variantId}")
    public ResponseEntity<ProductVariantResponse> get(@PathVariable Long variantId) {
        var result = productVariantService.get(variantId);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/variants")
    public ResponseEntity<List<ProductVariantResponse>> getAll() {
        var result = productVariantService.findAll();
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/by-product/{productId}")
    public ResponseEntity<List<ProductVariantResponse>> getAllByProductId(@PathVariable Long productId) {
        var result = productVariantService.findAllByProductId(productId);
        return ResponseEntity.ok().body(result);
    }
    @DeleteMapping("/variants/{variantId}")
    public ResponseEntity<ProductVariantResponse> delete(@PathVariable Long variantId) {
        productVariantService.delete(variantId);
        return ResponseEntity.noContent().build();
    }
}
