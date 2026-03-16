<template>
  <div>
    <Breadcrumb title="Kết quả thanh toán" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <section class="payment-result spad">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="payment-result__card" :class="paymentStatusClass">

              <!-- Loading -->
              <div v-if="loading" class="text-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Đang xử lý...</span>
                </div>
                <p class="mt-3">Đang xác nhận thanh toán...</p>
              </div>

              <!-- Kết quả -->
              <div v-else>
                <div class="payment-result__icon">
                  <i :class="iconClass"></i>
                </div>

                <h2>{{ title }}</h2>
                <p>{{ message }}</p>

                <div v-if="paymentData" class="payment-result__details">
                  <div class="detail-item">
                    <span>Mã đơn hàng:</span>
                    <strong>{{ paymentData.orderCode }}</strong>
                  </div>
                  <div class="detail-item">
                    <span>Số tiền:</span>
                    <strong>{{ formatCurrency(paymentData.amount) }}</strong>
                  </div>
                  <div class="detail-item">
                    <span>Trạng thái:</span>
                    <strong :class="'status-' + paymentData.status.toLowerCase()">
                      {{ getStatusText(paymentData.status) }}
                    </strong>
                  </div>
                </div>

                <div class="payment-result__actions">
                  <button v-if="isSuccess" class="site-btn" @click="goToOrder">
                    Xem đơn hàng
                  </button>
                  <button v-else-if="isCancel" class="site-btn" @click="goToCart">
                    Quay lại giỏ hàng
                  </button>
                  <button v-else class="site-btn" @click="goToHome">
                    Về trang chủ
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'
const route = useRoute()
const router = useRouter()

const loading = ref(true)
const paymentData = ref(null)
const error = ref(null)
// Lấy params từ URL khi redirect về
const queryParams = ref({})

onMounted(async () => {
  // Lấy tất cả query params từ URL
  queryParams.value = route.query

  console.log('Payment redirect params:', queryParams.value)

  // Nếu có orderCode, gọi API verify
  if (queryParams.value.orderCode) {

    await verifyPayment()
  } else {
    error.value = 'Không tìm thấy thông tin thanh toán'
    loading.value = false
  }
})

const verifyPayment = async () => {
  try {
    const token = localStorage.getItem('token')

    if (!token) {
      router.push('/login')
      return
    }

    // Gọi API verify
    const verifyResponse = await axios.post(
        'http://localhost:8080/payments/verify',
        {
          orderCode: queryParams.value.orderCode,
          status: queryParams.value.status,
          id: queryParams.value.id
        },
        {
          headers: { Authorization: `Bearer ${token}` }
        }
    )

    if (verifyResponse.data.success) {
      // Sau khi verify thành công, lấy chi tiết payment
      await getPaymentDetails(queryParams.value.orderCode)
    } else {
      error.value = verifyResponse.data.message || 'Xác thực thanh toán thất bại'
      loading.value = false
    }

  } catch (err) {
    console.error('Verify payment error:', err)
    error.value = err.response?.data?.message || 'Không thể xác thực thanh toán'
    loading.value = false
  }
}

const getPaymentDetails = async (orderCode) => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get(
        `http://localhost:8080/payments/status/${orderCode}`,
        {
          headers: { Authorization: `Bearer ${token}` }
        }
    )

    paymentData.value = response.data
    paymentData.value.orderCode = orderCode
    // Nếu thanh toán thành công, xóa giỏ hàng
    if (response.data.status === 'PAID') {
      localStorage.removeItem('ogani-cart')
    }

  } catch (err) {
    console.error('Get payment details error:', err)
  } finally {
    loading.value = false
  }
}

// Computed properties
const paymentStatusClass = computed(() => {
  if (error.value) return 'error'
  if (!paymentData.value) return 'pending'

  switch (paymentData.value.status) {
    case 'PAID': return 'success'
    case 'CANCELLED': return 'cancel'
    default: return 'pending'
  }
})

const isSuccess = computed(() => paymentData.value?.status === 'PAID')

const title = computed(() => {
  switch (paymentStatusClass.value) {
    case 'success': return 'Thanh toán thành công!'
    case 'cancel': return 'Thanh toán đã bị hủy'
    case 'error': return 'Có lỗi xảy ra'
    default: return 'Đang xử lý...'
  }
})

const message = computed(() => {
  switch (paymentStatusClass.value) {
    case 'success': return 'Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đang được xử lý.'
    case 'cancel': return 'Bạn đã hủy thanh toán.'
    case 'error': return error.value || 'Đã có lỗi xảy ra.'
    default: return 'Vui lòng chờ trong giây lát...'
  }
})

const iconClass = computed(() => {
  switch (paymentStatusClass.value) {
    case 'success': return 'fas fa-check-circle'
    case 'cancel': return 'fas fa-times-circle'
    case 'error': return 'fas fa-exclamation-triangle'
    default: return 'fas fa-spinner fa-spin'
  }
})

// Methods
const formatCurrency = (value) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(value)
}

const getStatusText = (status) => {
  const statusMap = {
    'PAID': 'Đã thanh toán',
    'PENDING': 'Chờ thanh toán',
    'CANCELLED': 'Đã hủy'
  }
  return statusMap[status] || status
}

const goToOrder = () => {
  router.push('/orders')
}

const goToCart = () => {
  router.push('/shoping-cart')
}

const goToHome = () => {
  router.push('/')
}
</script>

<style scoped>
.payment-result__card {
  text-align: center;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
  min-height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.payment-result__icon {
  font-size: 80px;
  margin-bottom: 20px;
}

.payment-result__card.success .payment-result__icon {
  color: #28a745;
}

.payment-result__card.cancel .payment-result__icon,
.payment-result__card.error .payment-result__icon {
  color: #dc3545;
}

.payment-result__details {
  margin: 30px 0;
  text-align: left;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 5px;
}

.detail-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  padding-bottom: 10px;
  border-bottom: 1px solid #dee2e6;
}

.detail-item:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.status-paid {
  color: #28a745;
  font-weight: bold;
}

.status-cancelled {
  color: #dc3545;
  font-weight: bold;
}

.payment-result__actions {
  margin-top: 20px;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}
</style>