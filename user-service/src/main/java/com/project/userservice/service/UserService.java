package com.project.userservice.service;

import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.UserResponse;
import com.project.userservice.entity.Users;
import com.project.userservice.mapper.UserMapper;
import com.project.userservice.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.sql.Timestamp;
import java.util.List;
import java.util.stream.Collectors;

@Service
public class UserService {
    @Autowired
    private UserRepository userRepository;
    @Autowired
    private UserMapper userMapper;
    @Autowired
    private PasswordEncoder passwordEncoder;



    public void createUser(UserRequest user) {
        String password = passwordEncoder.encode(user.getPassword());
        user.setPassword(password);
        user.setRole("USER");
        Users users = userMapper.toUsers(user);
        users.setStatus("PENDING");
        users.setCreatedAt(new Timestamp(System.currentTimeMillis()));
        users.setUpdatedAt(new Timestamp(System.currentTimeMillis()));
        userRepository.save(users);
    }
    public void activeUser(String email) {
        Users user = findByEmail(email);
        user.setStatus("ACTIVE");
        user.setUpdatedAt(new Timestamp(System.currentTimeMillis()));
        userRepository.save(user);
    }
    public UserResponse updateUser(UserRequest request) {
        Users user = findByEmail(request.getEmail()) ;
        if(user ==null )
            throw new UsernameNotFoundException("User not found");
        user.setFullName(request.getFullName());
        user.setPhone(request.getPhone());
        user.setUpdatedAt(new Timestamp(System.currentTimeMillis()));
        return userMapper.toUserResponse(user);
    }
    public void changePassword(String email, String oldPassword, String newPassword) {
        Users users = findByEmail(email);
        if(users ==null )
            throw new UsernameNotFoundException("User not found");
        if(!passwordEncoder.matches(oldPassword, users.getPassword()))
            throw new UsernameNotFoundException("password not match");
        users.setPassword(passwordEncoder.encode(newPassword));
        userRepository.save(users);
    }
    public UserResponse info(String email) {
        Users user = findByEmail(email);
        return toUserResponse(user);
    }
    public Users findByEmail(String email) {
        return userRepository.findByEmail(email);
    }

    public UserResponse toUserResponse(Users user) {
        return userMapper.toUserResponse(user);
    }
    public Users toUsers(UserRequest user) {
        return userMapper.toUsers(user);
    }
    public List<UserResponse> findAll() {
        return userRepository.findAll()
                .stream()
                .map(users -> userMapper.toUserResponse(users))
                .toList();
    }
}

