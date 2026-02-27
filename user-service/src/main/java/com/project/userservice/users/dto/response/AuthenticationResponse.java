package com.project.userservice.users.dto.response;

import lombok.*;
import lombok.experimental.FieldDefaults;

@Data
@FieldDefaults(level = AccessLevel.PRIVATE)
@AllArgsConstructor(access = AccessLevel.PUBLIC)
@NoArgsConstructor(access = AccessLevel.PUBLIC)
@Builder
public class AuthenticationResponse {
    String fullName;
    String token;
    String refreshToken;
    String role;
}
