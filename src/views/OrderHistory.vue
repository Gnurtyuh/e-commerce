<template>
    <section class="profile spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="profile__box">
                        <h3 class="profile__title">Lịch sử đơn hàng</h3>

                        <div class="order__table__wrap">
                            <table class="order__table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="order in orders" :key="order.id">
                                        <td>#{{ order.id }}</td>
                                        <td>{{ order.date }}</td>
                                        <td>${{ order.total }}</td>
                                        <td>
                                            <span class="order__status" :class="order.status.toLowerCase()">
                                                {{ order.status }}
                                            </span>
                                        </td>
                                        <td>
                                            <router-link :to="`/orders/${order.id}`" class="site-btn btn-sm">
                                                Xem chi tiết
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const orders = [
    {
        id: 101,
        date: '2024-05-01',
        total: 150.0,
        status: 'Hoàn thành'
    },
    {
        id: 102,
        date: '2024-05-10',
        total: 85.5,
        status: 'Đang xử lý'
    },
    {
        id: 103,
        date: '2024-05-15',
        total: 230.75,
        status: 'Đang giao'
    }
]
</script>
