package com.project.userservice.controller;

import com.project.userservice.dto.request.AuthenticationRequest;
import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.AuthenticationResponse;
import com.project.userservice.service.AuthenticationService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/auth")
public class AuthenticationController {
    @Autowired
    AuthenticationService authenticationService;
    @GetMapping("/login")
    public ResponseEntity<AuthenticationResponse> authenticate(@RequestBody AuthenticationRequest authenticationRequest) {
        var result = authenticationService.login(authenticationRequest);
        return ResponseEntity.ok(result);
    }
    @GetMapping("registry")
    public ResponseEntity<?> registry(@RequestBody UserRequest userRequest) {
        authenticationService.register(userRequest);
        return ResponseEntity.ok().build();
    }
}
