package com.project.userservice.users.dto.response;
import lombok.*;
import lombok.experimental.FieldDefaults;

import java.sql.Timestamp;
import java.util.UUID;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class UserResponse {
    UUID userId;
    String fullName;
    String email;
    String phone;
    String status;
    String role;
    Timestamp createdAt;
    Timestamp updatedAt;
}
