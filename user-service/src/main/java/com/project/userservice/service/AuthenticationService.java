package com.project.userservice.service;

import com.nimbusds.jose.JWSHeader;
import com.nimbusds.jose.JWSObject;
import com.project.userservice.dto.request.AuthenticationRequest;
import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.AuthenticationResponse;
import lombok.AccessLevel;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.UUID;

@Service
@FieldDefaults(level = AccessLevel.PRIVATE)
public class AuthenticationService {
    @Autowired
    PasswordEncoder passwordEncoder;
    @Autowired
    UserService userService;
    @Autowired
    JwtService jwtService;
    public AuthenticationResponse login(AuthenticationRequest request) {
        var user = userService.findByEmail(request.getEmail());
        if(user == null){ throw new UsernameNotFoundException("email or password invalid"); }
        if(!passwordEncoder.matches(request.getPassword(), user.getPassword()))
            throw new UsernameNotFoundException("email or password invalid");

        String token = jwtService.generateToken(userService.toUserResponse(user));
        String refreshToken = jwtService.generateToken(userService.toUserResponse(user));

        return AuthenticationResponse.builder()
                .token(token)
                .refreshToken(refreshToken)
                .role(user.getRole())
                .build();
    }
    public void register(UserRequest userRequest) {
        userService.createUser(userRequest);
    }

}
