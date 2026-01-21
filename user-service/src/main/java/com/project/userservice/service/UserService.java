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

@Service
public class UserService {
    @Autowired
    private UserRepository userRepository;
    @Autowired
    private UserMapper userMapper;

    @Autowired
    private PasswordEncoder passwordEncoder;
    public UserResponse createUser(UserRequest user) {
        String password = passwordEncoder.encode(user.getPassword());
        user.setPassword(password);
        Users users =userRepository.save(userMapper.toUsers(user));
        return userMapper.toUserResponse(users);
    }
    public UserResponse updateUser(UserRequest user) {
        if(findByEmail(user.getEmail()) ==null )
            throw new UsernameNotFoundException("User not found");
        Users users = userRepository.save(userMapper.toUsers(user));
        return userMapper.toUserResponse(users);
    }
    public UserResponse info(String email) {
        Users user = findByEmail(email);
        return userMapper.toUserResponse(user);
    }
    public Users findByEmail(String email) {
        return userRepository.findByEmail(email);
    }

}
