package com.project.userservice.service;

import com.nimbusds.jose.*;
import com.nimbusds.jose.crypto.MACSigner;
import com.nimbusds.jose.crypto.MACVerifier;
import com.nimbusds.jwt.JWTClaimsSet;
import com.nimbusds.jwt.SignedJWT;
import com.project.userservice.dto.request.IntrospectRequest;
import com.project.userservice.dto.request.UserRequest;
import com.project.userservice.dto.response.IntrospectResponse;
import com.project.userservice.dto.response.UserResponse;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import java.sql.Timestamp;
import java.text.ParseException;
import java.util.Date;
import java.util.UUID;

@Service
public class JwtService {

    @Value("${jwt.signKey}")
    private String jwtSignKey;
    public String generateToken(UserResponse request) {
        JWSHeader jwsHeader = new JWSHeader(JWSAlgorithm.HS512);
        Date expiration = new Timestamp(System.currentTimeMillis() + 3600 * 1000);
        String jti = UUID.randomUUID().toString();
        JWTClaimsSet jwtClaimsSet = new JWTClaimsSet.Builder()
                .jwtID(jti)
                .claim("fullName",request.getFullName())
                .expirationTime(expiration)
                .issuer(request.getEmail())
                .claim("role",request.getRole())
                .issueTime(new Date())
                .claim("type","Access")
                .build();
        Payload payload = new Payload(jwtClaimsSet.toJSONObject());
        JWSObject jwsObject = new JWSObject(jwsHeader,payload);
        try{
            jwsObject.sign(new MACSigner(jwtSignKey));
            return jwsObject.serialize();
        } catch (JOSEException e) {
            throw new RuntimeException(e);
        }
    }
    public String generateRefreshToken(UserResponse userRequest) {
        JWSHeader jwsHeader = new JWSHeader(JWSAlgorithm.HS512);
        Date expiration = new Timestamp(System.currentTimeMillis() + 3600 * 1000);
        String jti = UUID.randomUUID().toString();
        JWTClaimsSet jwtClaimsSet = new JWTClaimsSet.Builder()
                .jwtID(jti)
                .claim("fullName",userRequest.getFullName())
                .expirationTime(expiration)
                .issuer(userRequest.getEmail())
                .claim("role",userRequest.getRole())
                .issueTime(new Date())
                .claim("type","Refresh")
                .build();
        Payload payload = new Payload(jwtClaimsSet.toJSONObject());
        JWSObject jwsObject = new JWSObject(jwsHeader,payload);
        try{
            jwsObject.sign(new MACSigner(jwtSignKey));
            return jwsObject.serialize();
        } catch (JOSEException e) {
            throw new RuntimeException(e);
        }
    }
    public IntrospectResponse validateToken(IntrospectRequest introspectRequest) {
        var token = introspectRequest.getToken();
        try{
            JWSVerifier verifier = new MACVerifier(jwtSignKey);
            SignedJWT signedJWT = SignedJWT.parse(token);
            var verify = signedJWT.verify(verifier);
            Date expiration = signedJWT.getJWTClaimsSet().getExpirationTime();
            return IntrospectResponse.builder()
                    .valid(verify && expiration.before(new Date()))

                    .build();
        } catch (JOSEException | ParseException e) {
            throw new RuntimeException("Jwt verification failed" +e.getMessage());
        }
    }
}
