package com.project.userservice.users.service;

import com.project.userservice.users.dto.request.AddressRequest;
import com.project.userservice.users.dto.response.AddressResponse;
import com.project.userservice.users.entity.Addresses;
import com.project.userservice.users.mapper.AddressMapper;
import com.project.userservice.users.repository.AddressRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.UUID;
import java.util.stream.Collectors;

@Service

public class AddressService {
    @Autowired
    private AddressRepository addressRepository;
    @Autowired
    private UserService userService;

    public void createAddress(AddressRequest address) {
        if (userService.findByUserId(address.getUserId())==null) {
            throw new UsernameNotFoundException("User not found");
        }
        Addresses addresses = AddressMapper.toAddresses(address);
        address.setAddressId(null);
        Addresses address2 = addressRepository.findByAddressIdAndDefault(address.getUserId());
        if (address.getIsDefault() && address2 != null) {
            address2.setIsDefault(false);
        }
        addressRepository.save(addresses);
    }
    public void updateAddress(AddressRequest address) {
        if (findByAddressId(address.getAddressId())==null) {
            throw new RuntimeException("Address not found");
        }
        if (userService.findByUserId(address.getUserId())==null) {
            throw new UsernameNotFoundException("User not found");
        }
        if(address.getIsDefault()){
            Addresses addresses = addressRepository.findByAddressIdAndDefault(address.getUserId());
            addresses.setIsDefault(false);
            addressRepository.save(addresses);
        }
        Addresses addresses = AddressMapper.toAddresses(address);
        addressRepository.save(addresses);
    }
    public void deleteAddress(UUID  addressId) {
        if (addressId == null) {
            throw new RuntimeException("address not found");
        }
        addressRepository.deleteById(addressId);
    }
    public List<AddressResponse> getByUserId(UUID userId) {
        return addressRepository.findByUserId(userId)
                .stream()
                .map(AddressMapper::toAddressResponse)
                .collect(Collectors.toList());
    }

    public Addresses findByAddressId(UUID addressId) {
        return addressRepository.findById(addressId).orElse(null);
    }
    public AddressResponse getAddress(UUID addressId) {
        return AddressMapper.toAddressResponse(findByAddressId(addressId));
    }
}
