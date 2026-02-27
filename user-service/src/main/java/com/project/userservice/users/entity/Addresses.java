package com.project.userservice.users.entity;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.Id;
import jakarta.persistence.Table;
import lombok.*;
import lombok.experimental.FieldDefaults;

import java.sql.Timestamp;
import java.util.UUID;

@Data
@Entity
@Table(name ="addresses")
@FieldDefaults(level = AccessLevel.PRIVATE)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class Addresses {
    @Id
    @Column(name = "address_id", nullable = false, updatable = false)
    UUID addressId;
    @Column(name= "user_id")
    UUID userId;
    @Column(name= "receiver_name")
    String receiverName;
    @Column(name= "phone")
    String phone;
    @Column(name= "address")
    String address;
    @Column(name= "is_default")
    Boolean isDefault;
    @Column(name= "created_at")
    Timestamp createdAt;
}
