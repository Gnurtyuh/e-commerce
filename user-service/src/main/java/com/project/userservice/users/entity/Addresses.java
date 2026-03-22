package com.project.userservice.users.entity;

import jakarta.persistence.*;
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
    @GeneratedValue(strategy = GenerationType.UUID)
    @Column(name = "address_id", updatable = false)
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
    Timestamp createdAt = new Timestamp(System.currentTimeMillis());
}
