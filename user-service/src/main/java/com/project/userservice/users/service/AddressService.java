package com.project.userservice.users.service;

import com.project.userservice.users.dto.request.AddressRequest;
import com.project.userservice.users.dto.response.AddressResponse;
import com.project.userservice.users.entity.Addresses;
import com.project.userservice.users.mapper.AddressMapper;
import com.project.userservice.users.repository.AddressRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.server.ResponseStatusException;

import java.util.List;
import java.util.UUID;
import java.util.stream.Collectors;

@Service
@RequiredArgsConstructor
public class AddressService {
    private final AddressRepository addressRepository;
    private final UserService userService;
    @Transactional
    public void createAddress(UUID userId, AddressRequest req) {
        if (userService.findByUserId(userId)==null) {
            throw new UsernameNotFoundException("User not found");
        }
        addressRepository.deleteByUserId(userId);
        Addresses addresses = AddressMapper.toAddresses(req);
        addresses.setAddressId(null);
        addresses.setIsDefault(true);
        addressRepository.save(addresses);
    }
    @Transactional
    public void updateAddress(UUID addressId, AddressRequest address) {
        if (findByAddressId(addressId)==null ){
            throw new RuntimeException("Address not found");
        }
        if (userService.findByUserId(address.getUserId())==null) {
            throw new UsernameNotFoundException("User not found");
        }
        Addresses addresses = AddressMapper.toAddresses(address);
        addressRepository.save(addresses);
    }
    @Transactional
    public void deleteAddress(UUID  addressId) {
        if (addressId == null) {
            throw new RuntimeException("address not found");
        }
        addressRepository.deleteById(addressId);
    }
    public AddressResponse getByUserId(UUID userId) {
        Addresses address = addressRepository.findByUserId(userId);
        if (address == null) return  null;
        return AddressMapper.toAddressResponse(address );
    }

    public Addresses findByAddressId(UUID addressId) {
        return addressRepository.findById(addressId).orElseThrow( () ->  new ResponseStatusException(HttpStatus.NOT_FOUND,"Address not found"));
    }
    public AddressResponse getAddress(UUID addressId) {
        return AddressMapper.toAddressResponse(findByAddressId(addressId));
    }
}
