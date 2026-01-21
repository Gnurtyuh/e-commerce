package com.project.userservice.mapper;

import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.UserResponse;
import com.project.userservice.entity.Users;
import org.mapstruct.Mapper;
import org.mapstruct.factory.Mappers;

@Mapper(componentModel = "spring")
public interface UserMapper {
    UserMapper INSTANCE = Mappers.getMapper(UserMapper.class);
    UserResponse toUserResponse(Users users);
    Users toUsers(UserRequest users);
}
