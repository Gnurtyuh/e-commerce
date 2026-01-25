package com.project.userservice.controller;

import com.project.userservice.dto.request.AuthenticationRequest;
import com.project.userservice.dto.request.ChangePasswordRequest;
import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.AuthenticationResponse;
import com.project.userservice.service.AuthenticationService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/users/auth")
public class AuthenticationController {
    @Autowired
    AuthenticationService authenticationService;
    @PostMapping("/login")
    public ResponseEntity<AuthenticationResponse> authenticate(@RequestBody AuthenticationRequest authenticationRequest) {
        var result = authenticationService.login(authenticationRequest);
        return ResponseEntity.ok(result);
    }
    @PostMapping("/register")
    public ResponseEntity<?> register(@RequestBody UserRequest userRequest) {
        authenticationService.register(userRequest);
        return ResponseEntity.ok("register successfully");
    }
    @PostMapping("/change-password")
    public ResponseEntity<?> changePassword(@RequestBody ChangePasswordRequest changePasswordRequest) {
        authenticationService.changePassword(changePasswordRequest);
        return ResponseEntity.ok("password changed successfully");
    }
    @GetMapping("/status")
    public ResponseEntity<?> getStatus(@RequestParam String email) {
        var result = authenticationService.getStatus(email);
        return ResponseEntity.ok(result);
    }
}
