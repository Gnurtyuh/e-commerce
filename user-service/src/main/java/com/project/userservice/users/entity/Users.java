package com.project.userservice.users.entity;

import jakarta.persistence.*;
import lombok.*;
import lombok.experimental.FieldDefaults;

import java.sql.Timestamp;
import java.util.UUID;

@Data
@Entity
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
@Table(name ="users")
@FieldDefaults(level = AccessLevel.PRIVATE)
public class Users {
    @Id
    @Column(name = "user_id", nullable = false, updatable = false)
    @GeneratedValue
    UUID userId;
    @Column(name = "password")
    String password;
    @Column(name = "email")
    String email;
    @Column(name = "phone")
    String phone;
    @Column(name = "full_name")
    String fullName;
    @Column(name = "role")
    String role;
    @Column(name = "status")
    String status;
    @Column(name = "created_at")
    Timestamp createdAt;
    @Column(name = "updated_at")
    Timestamp updatedAt;
}
