<template>
    <section class="profile spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="profile__box">
                        <h3 class="profile__title">
                            Đơn hàng #{{ order.id }}
                        </h3>

                        <!-- THÔNG TIN ĐƠN HÀNG -->
                        <p><b>Ngày đặt:</b> {{ order.date }}</p>
                        <p><b>Trạng thái:</b> {{ order.status }}</p>

                        <!-- DANH SÁCH SẢN PHẨM -->
                        <h4 class="mt-4">Sản phẩm</h4>

                        <table class="order__table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="item in order.items" :key="item.id">
                                    <td>{{ item.name }}</td>
                                    <td>${{ item.price }}</td>
                                    <td>{{ item.quantity }}</td>
                                    <td>${{ item.price * item.quantity }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- TỔNG TIỀN -->
                        <div class="order__total">
                            <h4>Tổng cộng: ${{ order.total }}</h4>
                        </div>

                        <router-link to="/orders" class="site-btn mt-3">
                            Quay lại danh sách đơn hàng
                        </router-link>

                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
const orderId = route.params.id

// MOCK DATA
const order = {
    id: orderId,
    date: '2026-01-10',
    status: 'Hoàn thành',
    total: 120,
    items: [
        { id: 1, name: 'Crab Pool Security', price: 30, quantity: 2 },
        { id: 2, name: 'Fresh Organic Vegetables', price: 25, quantity: 2 }
    ]
}
</script>
