package com.project.userservice.product.service;

import com.project.userservice.product.dto.request.ProductImageRequest;
import com.project.userservice.product.dto.response.ProductImageResponse;
import com.project.userservice.product.entity.ProductImage;
import com.project.userservice.product.mapper.ProductImageMapper;
import com.project.userservice.product.repository.ProductImageRepository;
import com.project.userservice.product.repository.ProductRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@Transactional
@RequiredArgsConstructor
public class ProductImageService {
    private final ProductImageRepository imageRepository;
    private final ProductRepository productRepository;

    public ProductImageResponse addImage(Long productId, ProductImageRequest request) {

        // validate product tồn tại
        if (!productRepository.existsById(productId)) {
            throw new RuntimeException("Product not found");
        }

        // nếu ảnh là main → reset ảnh main cũ
        if (Boolean.TRUE.equals(request.getIsMain())) {
            imageRepository.findByProductIdOrderBySortOrderAsc(productId)
                    .forEach(img -> img.setIsMain(false));
        }

        ProductImage image = new ProductImage();
        image.setProductId(productId);
        image.setImagePath(request.getImagePath());
        image.setIsMain(Boolean.TRUE.equals(request.getIsMain()));
        image.setSortOrder(
                request.getSortOrder() != null ? request.getSortOrder() : 0
        );

        return ProductImageMapper.toResponse(imageRepository.save(image));
    }

    @Transactional(readOnly = true)
    public List<ProductImageResponse> getImagesByProduct(Long productId) {
        return imageRepository.findByProductIdOrderBySortOrderAsc(productId)
                .stream()
                .map(ProductImageMapper::toResponse)
                .toList();
    }

    public void deleteImage(Long imageId) {
        imageRepository.deleteById(imageId);
    }
    public void setMainImage(Long imageId) {

        ProductImage image = imageRepository.findById(imageId)
                .orElseThrow(() -> new RuntimeException("Image not found"));

        // reset main image của product
        imageRepository.findByProductIdOrderBySortOrderAsc(image.getProductId())
                .forEach(img -> img.setIsMain(false));

        image.setIsMain(true);
    }
}
