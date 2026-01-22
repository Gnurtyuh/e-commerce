package com.project.userservice.mapper;

import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.UserResponse;
import com.project.userservice.entity.Users;
import org.springframework.context.annotation.Bean;
import org.springframework.stereotype.Component;

@Component
public class UserMapper {
    public Users toUsers(UserRequest users) {
        Users user = new Users();
        user.setPassword(users.getPassword());
        user.setEmail(users.getEmail());
        user.setPhone(users.getPhone());
        user.setFullName(users.getFullName());
        user.setStatus(users.getStatus());
        user.setRole(users.getRole());
        return user;
    }
    public UserResponse toUserResponse(Users user) {
        UserResponse userResponse = new UserResponse();
        userResponse.setId(user.getUserId());
        userResponse.setFullName(user.getFullName());
        userResponse.setEmail(user.getEmail());
        userResponse.setPhone(user.getPhone());
        userResponse.setStatus(user.getStatus());
        userResponse.setRole(user.getRole());
        userResponse.setCreatedAt(user.getCreatedAt());
        userResponse.setUpdatedAt(user.getUpdatedAt());
        return userResponse;
    }
}
