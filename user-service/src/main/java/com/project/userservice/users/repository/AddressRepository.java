package com.project.userservice.users.repository;

import com.project.userservice.users.entity.Addresses;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.UUID;

@Repository
public interface AddressRepository extends JpaRepository<Addresses, UUID> {
    @Query("SELECT a from Addresses a where a.userId = ?1 and a.isDefault= true")
    Addresses findByAddressIdAndDefault(UUID userId);
    List<Addresses> findByUserId(UUID userId);
}
