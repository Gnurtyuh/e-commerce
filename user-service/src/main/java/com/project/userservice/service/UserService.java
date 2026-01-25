package com.project.userservice.service;

import com.project.userservice.dto.request.ChangePasswordRequest;
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
import java.util.UUID;

@Service
public class UserService {
    @Autowired
    private UserRepository userRepository;
    @Autowired
    private UserMapper userMapper;
    @Autowired
    private PasswordEncoder passwordEncoder;



    public void createUser(UserRequest request) {
        Users users = findByEmail(request.getEmail());
        if (users != null && users.getStatus().equals("ACTIVE")) {
            throw new UsernameNotFoundException("Email already in use");
        }
        if (users != null) {
            updateUser(request);
            return;
        }
        String password = passwordEncoder.encode(request.getPassword());
        request.setPassword(password);
        request.setRole("USER");
        Users user = userMapper.toUsers(request);
        user.setStatus("PENDING");
        user.setCreatedAt(new Timestamp(System.currentTimeMillis()));
        user.setUpdatedAt(new Timestamp(System.currentTimeMillis()));
        userRepository.save(user);
    }
    public void activeUser(String email) {
        Users user = findByEmail(email);
        user.setStatus("ACTIVE");
        user.setUpdatedAt(new Timestamp(System.currentTimeMillis()));
        userRepository.save(user);
    }
    public void updateUser(UserRequest request) {
        Users user = findByEmail(request.getEmail()) ;
        if(user ==null )
            throw new UsernameNotFoundException("User not found");
        user.setFullName(request.getFullName());
        user.setPhone(request.getPhone());
        user.setUpdatedAt(new Timestamp(System.currentTimeMillis()));
        userRepository.save(user);
    }
    public void changePassword(ChangePasswordRequest request) {
        Users users = findByEmail(request.getEmail());
        if(users == null )
            throw new UsernameNotFoundException("User not found");
        if(!passwordEncoder.matches(request.getOldPassword(), users.getPassword()))
            throw new UsernameNotFoundException("password not match");
        users.setPassword(passwordEncoder.encode(request.getNewPassword()));
        userRepository.save(users);
    }
    public UserResponse info(String email) {
        Users user = findByEmail(email);
        return toUserResponse(user);
    }
    public Users findByUserId(UUID userId) {
        return userRepository.findById(userId).orElseThrow(() -> new UsernameNotFoundException("User not found"));
    }
    public Users findByEmail(String email) {
        return userRepository.findByEmail(email);
    }
    public String getStatus(String email) {
        Users user = findByEmail(email);
        if(user ==null )
            throw new UsernameNotFoundException("User not found");
        return user.getStatus();
    }
    public UserResponse toUserResponse(Users user) {
        return userMapper.toUserResponse(user);
    }
    public Users toUsers(UserRequest user) {
        return userMapper.toUsers(user);
    }
    public List<UserResponse> getAll() {
        return userRepository.findAll()
                .stream()
                .map(users -> userMapper.toUserResponse(users))
                .toList();
    }
}

