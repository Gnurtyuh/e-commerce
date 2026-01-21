package com.project.userservice.controller;


import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.UserResponse;
import com.project.userservice.service.UserService;
import lombok.AccessLevel;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/users")
@FieldDefaults(level = AccessLevel.PRIVATE)
public class UserController {
    @Autowired
    UserService userService;
    @PostMapping("/registry")
    public ResponseEntity<UserResponse> createUser(@RequestBody UserRequest user) {
        var result = userService.createUser(user);
        return ResponseEntity.ok(result);
    }
    @PostMapping("")
    public ResponseEntity<UserResponse> updateUser(@RequestBody UserRequest user) {
        var result = userService.updateUser(user);
        return ResponseEntity.ok(result);
    }
    @GetMapping("/info")
    public ResponseEntity<UserResponse> info(String email) {
        var result = userService.info(email);
        return ResponseEntity.ok(result);
    }
}
