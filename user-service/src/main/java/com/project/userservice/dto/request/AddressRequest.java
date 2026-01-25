package com.project.userservice.dto.request;

import jakarta.persistence.Column;
import lombok.*;
import lombok.experimental.FieldDefaults;

import java.sql.Timestamp;
import java.util.UUID;
@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class AddressRequest {
    UUID addressId;
    UUID userId;
    String receiverName;
    String phone;
    String address;
    Boolean isDefault;

}
