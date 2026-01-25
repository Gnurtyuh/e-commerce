package com.project.userservice.mapper;


import com.project.userservice.dto.request.AddressRequest;
import com.project.userservice.dto.response.AddressResponse;
import com.project.userservice.entity.Addresses;
import org.springframework.stereotype.Component;

@Component
public class AddressMapper {
    public static Addresses toAddresses(AddressRequest addressRequest) {
        Addresses addresses = new Addresses();
        addresses.setAddressId(addressRequest.getAddressId());
        addresses.setAddress(addressRequest.getAddress());
        addresses.setPhone(addressRequest.getPhone());
        addresses.setUserId(addressRequest.getUserId());
        addresses.setIsDefault(addressRequest.getIsDefault());
        addresses.setReceiverName(addressRequest.getReceiverName());
        return addresses;
    }
    public static AddressResponse toAddressResponse(Addresses addresses) {
        AddressResponse addressResponse = new AddressResponse();
        addressResponse.setAddressId(addresses.getAddressId());
        addressResponse.setAddress(addresses.getAddress());
        addressResponse.setPhone(addresses.getPhone());
        addressResponse.setUserId(addresses.getUserId());
        addressResponse.setIsDefault(addresses.getIsDefault());
        addressResponse.setReceiverName(addresses.getReceiverName());
        addressResponse.setCreatedAt(addresses.getCreatedAt());
        return addressResponse;
    }
}
