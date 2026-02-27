package com.project.userservice.product.repository;

import com.project.userservice.product.entity.ProductVariant;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ProductVariantRepository extends JpaRepository<ProductVariant,Long> {
    @Query("select v from ProductVariant v where v.product.productId = :productId ")
    List<ProductVariant> findAllByProduct_ProductId(@Param("product_id") Long productId);
}
