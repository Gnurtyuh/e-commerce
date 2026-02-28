package com.project.userservice.product.controller;
import com.project.userservice.product.dto.request.ProductVariantRequest;
import com.project.userservice.product.dto.response.ProductVariantResponse;
import com.project.userservice.product.mapper.ProductVariantMapper;
import com.project.userservice.product.service.ProductVariantService;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.util.List;

@RestController
@RequestMapping("/variants")
@FieldDefaults(level = AccessLevel.PRIVATE)
@RequiredArgsConstructor
public class ProductVariantController {
    final ProductVariantService productVariantService;
    @PostMapping
    public ResponseEntity<ProductVariantResponse> create(@RequestBody ProductVariantRequest dto) {
        var result = productVariantService.create(dto);
        return ResponseEntity
                .created(URI.create("/variants/"+result.getVariantId()))
                .body(result);
    }
    @PutMapping("/{variantId}")
    public ResponseEntity<ProductVariantResponse> update(@PathVariable Long variantId, @RequestBody ProductVariantRequest dto) {
        var result = productVariantService.update(variantId, dto);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/{variantId}")
    public ResponseEntity<ProductVariantResponse> get(@PathVariable Long variantId) {
        var result = productVariantService.get(variantId);
        return ResponseEntity.ok().body(result);
    }
    @GetMapping()
    public ResponseEntity<List<ProductVariantResponse>> getAll() {
        var result = productVariantService.findAll();
        return ResponseEntity.ok().body(result);
    }
    @GetMapping("/by-product/{productId}")
    public ResponseEntity<List<ProductVariantResponse>> getAllByProductId(@RequestParam Long productId) {
        var result = productVariantService.findAllByProductId(productId);
        return ResponseEntity.ok().body(result);
    }
    @DeleteMapping("/{variantId}")
    public ResponseEntity<ProductVariantResponse> delete(@RequestParam Long variantId) {
        productVariantService.delete(variantId);
        return ResponseEntity.noContent().build();
    }
}
