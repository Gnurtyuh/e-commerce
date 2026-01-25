package com.project.userservice.controller;

import com.project.userservice.dto.request.AddressRequest;
import com.project.userservice.dto.response.AddressResponse;
import com.project.userservice.service.AddressService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.UUID;

@RestController
@RequestMapping("/users/address")
public class AddressController {
    @Autowired
    private AddressService addressService;
    @PostMapping
    public ResponseEntity<?> addAddress(@RequestBody AddressRequest address) {
        addressService.createAddress(address);
        return ResponseEntity.ok("The address has been created");
    }
    @PutMapping
    public ResponseEntity<?> updateAddress(@RequestBody AddressRequest address) {
        addressService.updateAddress(address);
        return ResponseEntity.ok("The address has been updated");
    }
    @DeleteMapping("/{addressId}")
    public ResponseEntity<?> deleteAddress(@PathVariable UUID addressId) {
        addressService.deleteAddress(addressId);
        return ResponseEntity.ok("The address has been deleted");
    }
    @GetMapping("/{addressId}")
    public ResponseEntity<?> getAddress(@PathVariable UUID addressId) {
        var result = addressService.getAddress(addressId);
        return ResponseEntity.ok(result);
    }
    @GetMapping("/{userId}/addresses")
    public ResponseEntity<?> getAddresses(@PathVariable UUID userId) {
        var result =  addressService.getByUserId(userId);
        return ResponseEntity.ok(result);
    }
}
