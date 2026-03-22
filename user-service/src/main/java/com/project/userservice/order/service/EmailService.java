package com.project.userservice.order.service;

import com.project.userservice.order.entity.Order;
import com.project.userservice.order.entity.OrderItem;
import com.project.userservice.product.entity.Product;
import com.project.userservice.product.entity.ProductVariant;
import com.project.userservice.product.repository.ProductRepository;
import com.project.userservice.product.repository.ProductVariantRepository;
import jakarta.mail.internet.MimeMessage;
import lombok.RequiredArgsConstructor;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;
import java.util.List;

@Service
@RequiredArgsConstructor
public class EmailService {

    private final JavaMailSender mailSender;
    private final ProductRepository productRepository;
    @Transactional
    public void sendOrderEmail(String to, Order order, List<OrderItem> items) {

        String subject = "Chi tiết đơn hàng #" + order.getOrderId();

        StringBuilder html = new StringBuilder();

        html.append("<h2>Chi tiết đơn hàng #").append(order.getOrderId()).append("</h2>");

        html.append("<p><b>Ngày đặt:</b> ").append(order.getCreatedAt()).append("</p>");
        html.append("<p><b>Trạng thái:</b> ").append(order.getStatus()).append("</p>");

        html.append("<h3>Sản phẩm đã đặt</h3>");

        html.append("<table border='1' cellpadding='10' cellspacing='0'>");
        html.append("<tr>");
        html.append("<th>Sản phẩm</th>");
        html.append("<th>Đơn giá</th>");
        html.append("<th>Số lượng</th>");
        html.append("<th>Thành tiền</th>");
        html.append("</tr>");

        for (OrderItem item : items) {
            Product product = productRepository.findById(item.getVariantId())
                    .orElseThrow(() -> new RuntimeException("Product not found"));
            html.append("<tr>");

            html.append("<td>")
                    .append(product.getName())
                    .append("</td>");

            html.append("<td>")
                    .append(item.getPrice())
                    .append(" VND</td>");

            html.append("<td>")
                    .append(item.getQuantity())
                    .append("</td>");

            html.append("<td>")
                    .append(item.getPrice().multiply(BigDecimal.valueOf(item.getQuantity())))
                    .append(" VND</td>");

            html.append("</tr>");
        }

        html.append("</table>");

        html.append("<h3>Tổng tiền: ")
                .append(order.getTotalAmount())
                .append(" VND</h3>");

        try {

            MimeMessage message = mailSender.createMimeMessage();

            MimeMessageHelper helper =
                    new MimeMessageHelper(message, true, "UTF-8");

            helper.setTo(to);
            helper.setSubject(subject);
            helper.setText(html.toString(), true);

            mailSender.send(message);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
