package com.project.userservice.service;

import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.security.SecureRandom;
import java.util.concurrent.TimeUnit;

@Service
@RequiredArgsConstructor
public class OtpService {
    private final PasswordEncoder passwordEncoder;
    private final JavaMailSender javaMailSender;
    private final RedisTemplate<String,String> redisTemplate;
    private static final int OTP_TIME_MINUTES = 5;
    @Autowired
    private UserService userService;
    String generateOtp(){
        return String.valueOf(100000 + new SecureRandom().nextInt(900000));
    }
    public void sendOtp(String email){
        String otp = generateOtp();
        String otpHash = passwordEncoder.encode(otp);
        String key = "otp:" + email;
        redisTemplate.opsForValue().set(key, otpHash,OTP_TIME_MINUTES, TimeUnit.MINUTES);
        sendEmail(email,otp);

    }
    public void sendEmail(String email, String otp){
        SimpleMailMessage simpleMailMessage = new SimpleMailMessage();
        simpleMailMessage.setTo(email);
        simpleMailMessage.setFrom(email);
        simpleMailMessage.setSubject("OTP Sent Successfully");
        simpleMailMessage.setText("OTP: " + otp+
                "\nMã có hiệu lực trong 5 phút");
        simpleMailMessage.setSentDate(new java.util.Date());
        javaMailSender.send(simpleMailMessage);
    }
    public void verifyOtp(String email,String otp){
        String key = "otp:" + email;
        String otpHash = redisTemplate.opsForValue().get(key);
        if(otpHash == null)
            throw new RuntimeException("otp hết hiệu lực");
        if(!passwordEncoder.matches(otp,otpHash))
            throw new RuntimeException("otp không hợp lệ");
        userService.activeUser(email);
        redisTemplate.delete(key);
    }
}
