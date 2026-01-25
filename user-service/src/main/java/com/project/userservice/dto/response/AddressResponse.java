package com.project.userservice.dto.response;

import lombok.*;
import lombok.experimental.FieldDefaults;

import java.sql.Timestamp;
import java.util.UUID;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class AddressResponse {
    UUID addressId;
    UUID userId;
    String receiverName;
    String phone;
    String address;
    Boolean isDefault;
    Timestamp createdAt;
}
