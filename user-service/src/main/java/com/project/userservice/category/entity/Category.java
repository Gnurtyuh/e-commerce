package com.project.userservice.category.entity;

import jakarta.persistence.*;
import lombok.*;
import lombok.experimental.FieldDefaults;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@Table(name ="categories")
@Entity
@Builder
public class Category {

    @Id
    @Column(name = "category_id", nullable = false, updatable = false)
    @GeneratedValue(strategy = GenerationType.SEQUENCE, generator = "categories_seq")
    @SequenceGenerator(
            name = "categories_seq",
            sequenceName = "categories_seq",
            allocationSize = 1
    )
    Long categoryId;

    @Column(name ="name")
    String name;

    @Column(name ="parent_id")
    Long parentId;
}