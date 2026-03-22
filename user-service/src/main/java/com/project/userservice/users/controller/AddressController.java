package com.project.userservice.users.controller;

import com.project.userservice.users.dto.request.AddressRequest;
import com.project.userservice.users.service.AddressService;
import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.UUID;

@RestController
@RequiredArgsConstructor
public class AddressController {
    private final AddressService addressService;
    @PostMapping("/users/{userId}/address")
    public ResponseEntity<?> addAddress(@PathVariable UUID userId,@RequestBody AddressRequest address) {
        addressService.createAddress(userId, address);
        return ResponseEntity.ok("The address has been created");
    }
    @PutMapping("/users/address/{addressId}")
    public ResponseEntity<?> updateAddress(@PathVariable UUID addressId,@RequestBody AddressRequest address) {
        addressService.updateAddress(addressId, address);
        return ResponseEntity.ok("The address has been updated");
    }
    @DeleteMapping("/users/address/{addressId}")
    public ResponseEntity<?> deleteAddress(@PathVariable UUID addressId) {
        addressService.deleteAddress(addressId);
        return ResponseEntity.ok("The address has been deleted");
    }
    @GetMapping("/users/address/{addressId}")
    public ResponseEntity<?> getAddress(@PathVariable UUID addressId) {
        var result = addressService.getAddress(addressId);
        return ResponseEntity.ok(result);
    }
    @GetMapping("/users/{userId}/address")
    public ResponseEntity<?> getAddressByUserId(@PathVariable UUID userId) {
        var result =  addressService.getByUserId(userId);
        return ResponseEntity.ok(result);
    }
}
