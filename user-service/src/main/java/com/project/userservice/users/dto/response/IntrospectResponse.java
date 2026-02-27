package com.project.userservice.users.dto.response;


import lombok.Builder;
import lombok.Data;

@Data
@Builder
public class IntrospectResponse {
    boolean valid;
}
