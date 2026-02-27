package com.project.userservice.users.controller;

import com.project.userservice.users.service.OtpService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/users/otp")
public class OtpController {
    @Autowired
    private OtpService otpService;
    @PostMapping("/send")
    public ResponseEntity<?> sendOtp(@RequestParam("email") String email){
        otpService.sendOtp(email);
        return ResponseEntity.ok("Otp send successfully");
    }
    @PostMapping("/verify")
    public ResponseEntity<?> verifyOtp(@RequestParam("email") String email, @RequestParam("otp") String otp){
        otpService.verifyOtp(email,otp);
        return ResponseEntity.ok("Otp verified successfully");
    }
}
