package com.project.userservice.product.service;

import com.project.userservice.category.service.CategoryService;
import com.project.userservice.product.dto.request.ProductVariantRequest;
import com.project.userservice.product.dto.response.ProductVariantResponse;
import com.project.userservice.product.entity.Product;
import com.project.userservice.product.entity.ProductVariant;
import com.project.userservice.product.mapper.ProductVariantMapper;
import com.project.userservice.product.repository.ProductVariantRepository;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;
import java.util.stream.Collectors;

@Service
@FieldDefaults(level = AccessLevel.PRIVATE)
@RequiredArgsConstructor(onConstructor_ = @Autowired)
public class ProductVariantService {

    final ProductVariantRepository productVariantRepository;

    final ProductService productService;
    @Transactional
    public ProductVariantResponse create(ProductVariantRequest dto) {
        Product product = productService.findById(dto.getProductId());
        return ProductVariantMapper.toResponse(
                productVariantRepository.save(
                        ProductVariantMapper.toEntity(dto,product))
        );
    }
    @Transactional
    public ProductVariantResponse update(Long variantId,ProductVariantRequest dto) {
        ProductVariant entity =  productVariantRepository.findById(variantId).orElseThrow(() -> new RuntimeException("Variant not found"));
        Product product = productService.findById(dto.getProductId());
        entity.setProduct(product);
        entity.setSku(dto.getSku());
        entity.setPrice(dto.getPrice());
        entity.setStock(dto.getStock());
        return ProductVariantMapper.toResponse(productVariantRepository.save(entity));
    }
    public void delete(Long variantId) {
        productVariantRepository.deleteById(variantId);
    }
    public List<ProductVariantResponse> findAll() {
        return productVariantRepository.findAll().stream().map(ProductVariantMapper::toResponse).collect(Collectors.toList());
    }
    public ProductVariantResponse get(Long variantId) {
        return productVariantRepository.findById(variantId).map(ProductVariantMapper::toResponse).orElseThrow(() -> new RuntimeException("Product not found"));
    }
    public List<ProductVariantResponse> findAllByProductId(Long productId) {
        return productVariantRepository.findAllByProduct_ProductId(productId)
                .stream()
                .map(ProductVariantMapper::toResponse)
                .toList();
    }
}
