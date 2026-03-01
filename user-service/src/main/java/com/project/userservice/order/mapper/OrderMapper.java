package com.project.userservice.order.mapper;
import com.project.userservice.order.dto.request.OrderRequest;
import com.project.userservice.order.dto.response.OrderItemResponse;
import com.project.userservice.order.dto.response.OrderResponse;
import com.project.userservice.order.entity.Order;
import com.project.userservice.order.entity.OrderItem;
import org.springframework.stereotype.Component;

@Component
public class OrderMapper {
    public static OrderResponse toResponse(Order order) {
        OrderResponse res = new OrderResponse();
        res.setOrderId(order.getOrderId());
        res.setUserId(order.getUserId());
        res.setStatus(order.getStatus());
        res.setTotalAmount(order.getTotalAmount());
        res.setCreatedAt(order.getCreatedAt());

        res.setItems(
                order.getItems().stream()
                        .map(OrderMapper::toItemResponse)
                        .toList()
        );

        return res;
    }

    public static OrderItemResponse toItemResponse(OrderItem item) {
        OrderItemResponse res = new OrderItemResponse();
        res.setOrderItemId(item.getOrderItemId());
        res.setVariantId(item.getVariantId());
        res.setPrice(item.getPrice());
        res.setQuantity(item.getQuantity());
        return res;
    }
}
