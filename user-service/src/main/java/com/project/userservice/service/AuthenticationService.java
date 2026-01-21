package com.project.userservice.service;

import com.project.userservice.dto.request.AuthenticationRequest;
import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.AuthenticationResponse;
import lombok.AccessLevel;
import lombok.experimental.FieldDefaults;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
@FieldDefaults(level = AccessLevel.PRIVATE)
public class AuthenticationService {
    @Autowired
    PasswordEncoder passwordEncoder;
    @Autowired
    UserService userService;
    public AuthenticationResponse login(AuthenticationRequest request) {
        var user = userService.findByEmail(request.getEmail());
        if(user == null){ throw new UsernameNotFoundException("email or password invalid"); }
        if(!passwordEncoder.matches(request.getPassword(), user.getPassword()))
            throw new UsernameNotFoundException("email or password invalid");
        return AuthenticationResponse.builder().build();
    }
    public void register(UserRequest userRequest) {
        userService.createUser(userRequest);
    }

}
