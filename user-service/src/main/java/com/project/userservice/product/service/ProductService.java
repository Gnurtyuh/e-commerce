package com.project.userservice.product.service;

import com.project.userservice.product.dto.request.ProductRequest;
import com.project.userservice.product.dto.response.ProductResponse;
import com.project.userservice.product.entity.Product;
import com.project.userservice.product.mapper.ProductMapper;
import com.project.userservice.product.repository.ProductRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.stream.Collectors;

@Service
public class ProductService {
    @Autowired
    private ProductRepository productRepository;

    public List<ProductResponse> findAll() {
        return productRepository.findAll().stream().map(ProductMapper::toResponse).collect(Collectors.toList());
    }
    public ProductResponse get(Long productId) {
        return productRepository.findById(productId).map(ProductMapper::toResponse).orElseThrow(() -> new RuntimeException("Product not found"));
    }
    public Product findById(Long productId) {
        return productRepository.findById(productId).orElseThrow(() -> new RuntimeException("Product not found"));
    }
    public ProductResponse create(ProductRequest productRequest) {
        Product product = productRepository.save(ProductMapper.toEntity(productRequest));
        return ProductMapper.toResponse(product);
    }
    public ProductResponse update(Long productId ,ProductRequest productRequest) {
        Product product = productRepository.findById(productId).orElseThrow(() -> new RuntimeException("Product not found"));
        product.setName(productRequest.getName());
        product.setDescription(productRequest.getDescription());
        product.setStatus(productRequest.getStatus());
        product.setCategoryId(productRequest.getCategoryId());
        return ProductMapper.toResponse(productRepository.save(product));
    }
    public void delete(Long productId) {
        Product product = productRepository.findById(productId).orElseThrow(() -> new RuntimeException("Product not found"));
        productRepository.delete(product);
    }
}
