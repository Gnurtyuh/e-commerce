package com.project.userservice.product.controller;

import com.project.userservice.product.dto.request.ProductImageRequest;
import com.project.userservice.product.dto.response.ProductImageResponse;
import com.project.userservice.product.service.ProductImageService;
import io.swagger.v3.oas.annotations.Operation;
import io.swagger.v3.oas.annotations.tags.Tag;
import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequiredArgsConstructor
@RequestMapping("/products")
@Tag(name = "Product Image API", description = "Quản lý hình ảnh sản phẩm")
public class ProductImageController {

    private final ProductImageService imageService;

    // ==========================
    // ADD IMAGE
    // ==========================
    @PostMapping("/{productId}/images")
    @Operation(summary = "Thêm ảnh cho sản phẩm")
    public ResponseEntity<ProductImageResponse> addImage(
            @PathVariable Long productId,
            @RequestBody ProductImageRequest request
    ) {
        return ResponseEntity.ok(
                imageService.addImage(productId, request)
        );
    }

    // ==========================
    // GET IMAGES
    // ==========================
    @GetMapping("/{productId}/images")
    @Operation(summary = "Lấy danh sách ảnh của sản phẩm")
    public ResponseEntity<List<ProductImageResponse>> getImages(
            @PathVariable Long productId
    ) {
        return ResponseEntity.ok(
                imageService.getImagesByProduct(productId)
        );
    }

    // ==========================
    // DELETE IMAGE
    // ==========================
    @DeleteMapping("/images/{imageId}")
    @Operation(summary = "Xóa ảnh")
    public ResponseEntity<Void> deleteImage(
            @PathVariable Long imageId
    ) {
        imageService.deleteImage(imageId);
        return ResponseEntity.noContent().build();
    }

    // ==========================
    // SET MAIN IMAGE
    // ==========================
    @PatchMapping("/images/{imageId}/main")
    @Operation(summary = "Đặt ảnh làm ảnh chính")
    public ResponseEntity<Void> setMainImage(
            @PathVariable Long imageId
    ) {
        imageService.setMainImage(imageId);
        return ResponseEntity.noContent().build();
    }
}
