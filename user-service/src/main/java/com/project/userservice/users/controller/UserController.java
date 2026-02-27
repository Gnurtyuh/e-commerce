package com.project.userservice.users.controller;


import com.project.userservice.users.dto.request.UserRequest;
import com.project.userservice.users.dto.response.UserResponse;
import com.project.userservice.users.service.UserService;
import lombok.AccessLevel;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/users/user")
@FieldDefaults(level = AccessLevel.PRIVATE)
public class UserController {
    @Autowired
    UserService userService;

    @PostMapping("")
    public ResponseEntity<?> updateUser(@RequestBody UserRequest user) {
        userService.updateUser(user);
        return ResponseEntity.ok("Update user successful");
    }
    @GetMapping("/info")
    public ResponseEntity<UserResponse> info(String email) {
        var result = userService.info(email);
        return ResponseEntity.ok(result);
    }
    @GetMapping("/users")
    public ResponseEntity<List<UserResponse>> getAllUsers() {
        var result = userService.getAll();
        return ResponseEntity.ok(result);
    }

}
