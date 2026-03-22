package com.project.userservice.users.mapper;


import com.project.userservice.users.dto.request.AddressRequest;
import com.project.userservice.users.dto.response.AddressResponse;
import com.project.userservice.users.entity.Addresses;
import org.springframework.stereotype.Component;

@Component
public class AddressMapper {
    public static Addresses toAddresses(AddressRequest addressRequest) {
        Addresses addresses = new Addresses();
        addresses.setAddress(addressRequest.getAddress());
        addresses.setPhone(addressRequest.getPhone());
        addresses.setUserId(addressRequest.getUserId());
        addresses.setIsDefault(true);
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
