package com.project.userservice.order.controller;

import com.project.userservice.order.dto.request.OrderRequest;
import com.project.userservice.order.dto.response.OrderItemResponse;
import com.project.userservice.order.dto.response.OrderResponse;
import com.project.userservice.order.service.OrderService;
import lombok.AccessLevel;
import lombok.RequiredArgsConstructor;
import lombok.experimental.FieldDefaults;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.util.List;

@RestController
@RequestMapping("/orders")
@FieldDefaults(level = AccessLevel.PRIVATE, makeFinal = true)
@RequiredArgsConstructor
public class OrderController {
    OrderService orderService;
    @PostMapping
    public ResponseEntity<OrderResponse> createOrder(@RequestBody OrderRequest orderRequest) {
        var result = orderService.createOrder(orderRequest);
        return ResponseEntity
                .created(URI.create("/orders/"+result.getOrderId()))
                .body(result);
    }
    @GetMapping("/{orderId}")
    public ResponseEntity<OrderResponse> getOrder(@PathVariable Long orderId) {
        var result = orderService.getOrderById(orderId);
        return ResponseEntity.ok(result);
    }
    @GetMapping("/{orderId}/items")
    public ResponseEntity<List<OrderItemResponse>> getOrderItems(@PathVariable Long orderId) {
        var result = orderService.getOrderItems(orderId);
        return ResponseEntity.ok(result);
    }
    @GetMapping()
    public ResponseEntity<List<OrderResponse>> getOrders() {
        var result = orderService.getAllOrders();
        return ResponseEntity.ok(result);
    }
}
