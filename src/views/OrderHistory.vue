<template>
  <section class="profile spad">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">

          <div class="profile__box">
            <h3 class="profile__title">Lịch sử đơn hàng</h3>

            <!-- Loading state -->
            <div v-if="loading" class="text-center py-5">
              <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Đang tải...</span>
              </div>
              <p class="mt-3">Đang tải đơn hàng...</p>
            </div>

            <!-- Error state -->
            <div v-else-if="error" class="text-center py-5">
              <i class="fas fa-exclamation-circle text-danger" style="font-size: 48px;"></i>
              <p class="mt-3 text-danger">{{ error }}</p>
              <button class="site-btn btn-sm mt-3" @click="fetchOrders">Thử lại</button>
            </div>

            <!-- Empty state -->
            <div v-else-if="orders.length === 0" class="text-center py-5">
              <i class="fas fa-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
              <p class="mt-3">Bạn chưa có đơn hàng nào</p>
              <router-link to="/shop" class="site-btn btn-sm mt-3">
                Mua sắm ngay
              </router-link>
            </div>

            <!-- Order table -->
            <div v-else class="order__table__wrap">
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
                <tr v-for="order in orders" :key="order.orderId">
                  <td>#{{ order.orderId }}</td>
                  <td>{{ formatDate(order.createdAt) }}</td>
                  <td>{{ formatCurrency(order.totalAmount) }}</td>
                  <td>
                    <span class="order__status" :class="getStatusClass(order.status)">
                      {{ getStatusText(order.status) }}
                    </span>
                  </td>

                  <td>
                    <router-link :to="`/orders/${order.orderId}`" class="site-btn btn-sm">
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
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const orders = ref([])
const loading = ref(true)
const error = ref(null)

// Fetch orders khi component mounted
onMounted(() => {
  fetchOrders()
})

const fetchOrders = async () => {
  const token = localStorage.getItem('token')

  if (!token) {
    router.push('/login')
    return
  }

  loading.value = true
  error.value = null

  try {
    const response = await axios.get('http://localhost:8080/orders', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })

    orders.value = response.data
    console.log('Orders fetched:', orders.value)

  } catch (err) {
    console.error('Error fetching orders:', err)
    error.value = err.response?.data?.message || 'Không thể tải danh sách đơn hàng'
  } finally {
    loading.value = false
  }
}

// Format date
const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('vi-VN', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Format currency
const formatCurrency = (amount) => {
  if (!amount) return '0 VND'
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount)
}

// Get status class for styling
const getStatusClass = (status) => {
  const statusMap = {
    'PENDING': 'pending',
    'PROCESSING': 'processing',
    'SHIPPING': 'shipping',
    'DELIVERED': 'delivered',
    'COMPLETED': 'completed',
    'CANCELLED': 'cancelled',
    'PAID': 'paid'
  }
  return statusMap[status] || 'pending'
}

// Get status text in Vietnamese
const getStatusText = (status) => {
  const statusMap = {
    'PENDING': 'Chờ xử lý',
    'PROCESSING': 'Đang xử lý',
    'SHIPPING': 'Đang giao',
    'DELIVERED': 'Đã giao',
    'COMPLETED': 'Hoàn thành',
    'CANCELLED': 'Đã hủy',
    'PAID': 'Đã thanh toán'
  }
  return statusMap[status] || status
}


</script>

<style scoped>
.profile__box {
  background: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.profile__title {
  margin-bottom: 30px;
  padding-bottom: 15px;
  border-bottom: 2px solid #f0f0f0;
  font-size: 24px;
  font-weight: 600;
}

.order__table__wrap {
  overflow-x: auto;
}

.order__table {
  width: 100%;
  border-collapse: collapse;
}

.order__table th {
  background: #f8f9fa;
  padding: 15px;
  font-weight: 600;
  text-align: left;
  border-bottom: 2px solid #dee2e6;
}

.order__table td {
  padding: 15px;
  border-bottom: 1px solid #e9ecef;
}

.order__status {
  display: inline-block;
  padding: 5px 15px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}

.order__status.pending {
  background: #fff3cd;
  color: #856404;
}

.order__status.processing {
  background: #cce5ff;
  color: #004085;
}

.order__status.shipping {
  background: #d4edda;
  color: #155724;
}

.order__status.delivered,
.order__status.completed,
.order__status.paid {
  background: #28a745;
  color: white;
}

.order__status.cancelled {
  background: #f8d7da;
  color: #721c24;
}

.payment__status {
  display: inline-block;
  padding: 5px 15px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}

.payment__status.paid {
  background: #28a745;
  color: white;
}

.payment__status.pending {
  background: #fff3cd;
  color: #856404;
}

.payment__status.failed,
.payment__status.cancelled {
  background: #f8d7da;
  color: #721c24;
}

.site-btn.btn-sm {
  padding: 5px 15px;
  font-size: 13px;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}

.text-center {
  text-align: center;
}

.py-5 {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.mt-3 {
  margin-top: 1rem;
}

.fa-shopping-bag,
.fa-exclamation-circle {
  margin-bottom: 15px;
}
</style>