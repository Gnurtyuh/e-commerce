<template>
  <section class="profile spad">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="profile__box">

            <!-- Loading State -->
            <div v-if="loading" class="text-center py-5">
              <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Đang tải...</span>
              </div>
              <p class="mt-3">Đang tải thông tin đơn hàng...</p>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center py-5">
              <i class="fas fa-exclamation-circle text-danger" style="font-size: 48px;"></i>
              <p class="mt-3 text-danger">{{ error }}</p>
              <button class="site-btn btn-sm mt-3" @click="fetchOrderDetail">
                Thử lại
              </button>
            </div>

            <!-- Order Detail -->
            <div v-else-if="order">
              <h3 class="profile__title">
                Đơn hàng #{{ order.orderId }}
              </h3>

              <!-- Thông tin đơn hàng -->
              <div class="order-info-grid">
                <div class="info-item">
                  <span class="label">Ngày đặt:</span>
                  <span class="value">{{ formatDate(order.createdAt) }}</span>
                </div>
                <div class="info-item">
                  <span class="label">Trạng thái:</span>
                  <span class="value">
                    <span class="order__status" :class="getStatusClass(order.status)">
                      {{ getPaymentStatusText(order.status) }}
                    </span>
                  </span>
                </div>

              </div>

              <!-- Thông tin giao hàng -->
              <div v-if="order.shippingAddress" class="shipping-info mt-4">
                <h4>Thông tin giao hàng</h4>
                <div class="address-grid">
                  <p><strong>Người nhận:</strong> {{ order.shippingAddress.recipientName }}</p>
                  <p><strong>Số điện thoại:</strong> {{ order.shippingAddress.phone }}</p>
                  <p><strong>Email:</strong> {{ order.shippingAddress.email }}</p>
                  <p><strong>Địa chỉ:</strong> {{ formatAddress(order.shippingAddress) }}</p>
                </div>
              </div>

              <!-- Danh sách sản phẩm -->
              <h4 class="mt-4">Sản phẩm đã đặt</h4>

              <div v-if="loadingItems" class="text-center py-3">
                <div class="spinner-border spinner-sm" role="status">
                  <span class="sr-only">Đang tải sản phẩm...</span>
                </div>
              </div>

              <div v-else-if="orderItems.length === 0" class="text-center py-3">
                <p>Không có sản phẩm nào</p>
              </div>

              <table v-else class="order__table">
                <thead>
                <tr>
                  <th>Sản phẩm</th>
                  <th>Đơn giá</th>
                  <th>Số lượng</th>
                  <th>Thành tiền</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="item in orderItems" :key="item.orderItemId">
                  <td>
                    <div class="product-info">
                      <span class="product-name">{{ item.productName }}</span>
                    </div>
                  </td>
                  <td>{{ (item.price) }} VND</td>
                  <td>{{ item.quantity }}</td>
                  <td>{{ (item.price * item.quantity) }} VND</td>
                </tr>
                </tbody>

                <!-- Tổng tiền -->
                <tfoot>
                <tr>
                  <td colspan="3" class="text-right">Tạm tính:</td>
                  <td>{{ (order.subtotal || order.totalAmount) }} VND</td>
                </tr>
                <tr class="total-row">
                  <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                  <td><strong>{{ (order.totalAmount) }} VND</strong></td>
                </tr>
                </tfoot>
              </table>

              <!-- Nút quay lại -->
              <div class="action-buttons mt-4">
                <router-link to="/orders" class="site-btn">
                  <i class="fa fa-arrow-left"></i> Quay lại danh sách
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()
const orderId = route.params.id

const order = ref(null)
const orderItems = ref([])
const loading = ref(true)
const loadingItems = ref(true)
const error = ref(null)

onMounted(() => {
  fetchOrderDetail()
})

// Fetch thông tin đơn hàng
const fetchOrderDetail = async () => {
  const token = localStorage.getItem('token')

  if (!token) {
    router.push('/login')
    return
  }

  loading.value = true
  error.value = null

  try {
    // Gọi API lấy thông tin đơn hàng
    const orderResponse = await axios.get(
        `http://localhost:8080/orders/${orderId}`,
        {
          headers: { Authorization: `Bearer ${token}` }
        }
    )

    order.value = orderResponse.data
    console.log('Order detail:', order.value)

    // Sau khi có order, fetch danh sách sản phẩm
    await fetchOrderItems()

  } catch (err) {
    console.error('Error fetching order:', err)
    error.value = err.response?.data?.message || 'Không thể tải thông tin đơn hàng'
  } finally {
    loading.value = false
  }
}

// Fetch danh sách sản phẩm trong đơn hàng
const fetchOrderItems = async () => {
  const token = localStorage.getItem('token')

  loadingItems.value = true

  try {
    const itemsResponse = await axios.get(
        `http://localhost:8080/orders/${orderId}/items`,
        {
          headers: { Authorization: `Bearer ${token}` }
        }
    )

    // Lưu order items gốc
    const items = itemsResponse.data
    console.log('Order items raw:', items)

    // Fetch thông tin chi tiết cho từng sản phẩm (chỉ lấy tên, không lấy ảnh)
    orderItems.value = await Promise.all(
        items.map(async (item) => {
          try {
            // Gọi API lấy thông tin sản phẩm theo variantId
            const productResponse = await axios.get(
                `http://localhost:8080/products/${item.variantId}`,
                {
                  headers: { Authorization: `Bearer ${token}` }
                }
            )

            // Chỉ lấy tên sản phẩm, không lấy ảnh
            return {
              ...item,
              productName: productResponse.data.name || 'Sản phẩm không tên'
            }
          } catch (err) {
            console.error(`Error fetching product ${item.variantId}:`, err)
            // Nếu lỗi, trả về item với tên mặc định
            return {
              ...item,
              productName: 'Sản phẩm không tồn tại'
            }
          }
        })
    )

    console.log('Order items with product info:', orderItems.value)

  } catch (err) {
    console.error('Error fetching order items:', err)
  } finally {
    loadingItems.value = false
  }
}



// Format functions
const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleString('vi-VN', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatAddress = (address) => {
  if (!address) return 'N/A'
  const parts = [
    address.addressDetail,
    address.ward,
    address.district,
    address.city
  ].filter(part => part && part.trim() !== '')

  return parts.join(', ') || 'N/A'
}

// Status functions
const getStatusClass = (status) => {
  const map = {
    'PENDING': 'pending',
    'PROCESSING': 'processing',
    'SHIPPING': 'shipping',
    'DELIVERED': 'delivered',
    'COMPLETED': 'completed',
    'CANCELLED': 'cancelled',
    'PAID': 'paid'
  }
  return map[status] || 'pending'
}

const getPaymentStatusText = (status) => {
  const map = {
    'PAID': 'Đã thanh toán',
    'PENDING': 'Chờ thanh toán',
    'FAILED': 'Thất bại',
    'CANCELLED': 'Đã hủy'
  }
  return map[status] || status
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

.order-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 15px;
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.info-item {
  display: flex;
  flex-direction: column;
}

.info-item .label {
  font-size: 14px;
  color: #6c757d;
  margin-bottom: 5px;
}

.info-item .value {
  font-size: 16px;
  font-weight: 500;
}

.shipping-info {
  background: #f8f9fa;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.shipping-info h4 {
  margin-bottom: 15px;
  font-size: 18px;
  font-weight: 600;
}

.address-grid p {
  margin-bottom: 8px;
}

.address-grid strong {
  min-width: 100px;
  display: inline-block;
}

.order__table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

.order__table th {
  background: #f8f9fa;
  padding: 12px;
  font-weight: 600;
  text-align: left;
  border-bottom: 2px solid #dee2e6;
}

.order__table td {
  padding: 12px;
  border-bottom: 1px solid #e9ecef;
  vertical-align: middle;
}

.order__table tfoot td {
  background: #f8f9fa;
  font-weight: 500;
}

.order__table tfoot .total-row td {
  font-size: 18px;
  color: #e53637;
}

.text-right {
  text-align: right;
}

.product-info {
  display: flex;
  align-items: center;
}

.product-name {
  font-weight: 500;
}

.order__status {
  display: inline-block;
  padding: 5px 15px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}
.order__status.paid {
  background: #28a745;
  color: white;
}

.payment__status {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}


.payment__status.paid { background: #28a745; color: white; }
.payment__status.pending { background: #fff3cd; color: #856404; }
.payment__status.failed,
.payment__status.cancelled { background: #f8d7da; color: #721c24; }

.action-buttons {
  display: flex;
  gap: 10px;
  justify-content: flex-start;
}

.site-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 25px;
  font-size: 14px;
  font-weight: 600;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s;
}

.site-btn i {
  font-size: 14px;
}

.cancel-btn {
  background: #dc3545;
  color: white;
}

.cancel-btn:hover {
  background: #c82333;
}

.pay-btn {
  background: #28a745;
  color: white;
}

.pay-btn:hover {
  background: #218838;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}

.spinner-sm {
  width: 2rem;
  height: 2rem;
}

.mt-3 { margin-top: 1rem; }
.mt-4 { margin-top: 2rem; }
.ml-2 { margin-left: 0.5rem; }
.py-3 { padding-top: 1rem; padding-bottom: 1rem; }
.py-5 { padding-top: 3rem; padding-bottom: 3rem; }
</style>