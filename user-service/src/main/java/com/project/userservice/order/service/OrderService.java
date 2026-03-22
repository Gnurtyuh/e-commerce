package com.project.userservice.order.service;

import com.project.userservice.order.dto.request.OrderItemRequest;
import com.project.userservice.order.dto.request.OrderRequest;
import com.project.userservice.order.dto.response.OrderItemResponse;
import com.project.userservice.order.dto.response.OrderResponse;
import com.project.userservice.order.entity.Order;
import com.project.userservice.order.entity.OrderItem;
import com.project.userservice.order.mapper.OrderMapper;
import com.project.userservice.order.repository.OrderRepository;
import com.project.userservice.product.entity.ProductVariant;
import com.project.userservice.product.repository.ProductVariantRepository;
import com.project.userservice.users.entity.Users;
import com.project.userservice.users.repository.UserRepository;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;

@Service
@FieldDefaults(level = AccessLevel.PRIVATE,makeFinal=true)
@RequiredArgsConstructor(access = AccessLevel.PUBLIC)
public class OrderService {
    OrderRepository orderRepository;
    ProductVariantRepository variantRepository;
    UserRepository userRepository;
    EmailService emailService;
    @Transactional
    public OrderResponse createOrder(OrderRequest request){
        Order order = new Order();
        order.setUserId(request.getUserId());
        order.setStatus("CREATED");
        BigDecimal total = BigDecimal.ZERO;
        List<OrderItem> orderItems = new ArrayList<>();
        for (OrderItemRequest reqItem : request.getItems()) {

            ProductVariant variant = variantRepository.findById(reqItem.getVariantId())
                    .orElseThrow(() -> new RuntimeException("Variant not found"));

            if (variant.getStock() < reqItem.getQuantity()) {
                throw new RuntimeException("Out of stock");
            }

            OrderItem item = new OrderItem();
            item.setOrder(order);
            item.setVariantId(variant.getVariantId());
            item.setPrice(variant.getPrice());
            item.setQuantity(reqItem.getQuantity());

            orderItems.add(item);

            total = total.add(
                    variant.getPrice()
                            .multiply(BigDecimal.valueOf(reqItem.getQuantity()))
            );

        }
        order.setTotalAmount(total);
        order.setItems(orderItems);
        return OrderMapper.toResponse(orderRepository.save(order));
    };
    @Transactional
    public void updateOrderPaid(Long orderId) {

        Order order = orderRepository.findById(orderId)
                .orElseThrow(() -> new RuntimeException("Order not found"));

        if ("PAID".equals(order.getStatus())) {
            return;
        }

        for (OrderItem item : order.getItems()) {

            ProductVariant variant = variantRepository.findById(item.getVariantId())
                    .orElseThrow(() -> new RuntimeException("Variant not found"));

            if (variant.getStock() < item.getQuantity()) {
                throw new RuntimeException("Out of stock");
            }

            variant.setStock(variant.getStock() - item.getQuantity());
        }
        Users user = userRepository.findById(order.getUserId())
                .orElseThrow(() -> new RuntimeException("User not found"));
        emailService.sendOrderEmail(
                user.getEmail(),
                order,
                order.getItems());
        order.setStatus("PAID");
    }
    @Transactional(readOnly = true)
    public OrderResponse getOrderById(Long orderId){
        return orderRepository.findById(orderId)
                .map(OrderMapper::toResponse)
                .orElseThrow(()->new RuntimeException("Order not found"));
    };
    @Transactional(readOnly = true)
    public List<OrderItemResponse> getOrderItems(Long orderId){
        Order entity = orderRepository.findById(orderId)
                .orElseThrow(()->new RuntimeException("Order not found"));
        return entity.getItems()
                .stream().map(OrderMapper::toItemResponse)
                .toList();
    };
    @Transactional(readOnly = true)
    public List<OrderResponse> getAllOrders(){
        return orderRepository.findAll()
                .stream().map(OrderMapper::toResponse)
                .filter(order -> order.getStatus().equals("PAID"))
                .toList();
    }
}

