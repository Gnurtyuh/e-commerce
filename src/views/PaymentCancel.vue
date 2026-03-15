<template>
  <div>
    <Breadcrumb title="Thanh toán thất bại" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <section class="payment-result spad">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="payment-result__card cancel">

              <div class="payment-result__icon">
                <i class="fas fa-times-circle"></i>
              </div>

              <h2>Thanh toán đã bị hủy</h2>
              <p>Bạn đã hủy giao dịch thanh toán.</p>

              <div v-if="route.query.orderCode" class="payment-result__details">
                <div class="detail-item">
                  <span>Mã đơn hàng:</span>
                  <strong>{{ route.query.orderCode }}</strong>
                </div>
              </div>

              <div class="payment-result__actions">
                <button class="site-btn" @click="goToCart">
                  Quay lại giỏ hàng
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import Breadcrumb from '@/components/layout/Breadcrumb.vue'

const route = useRoute()
const router = useRouter()

const goToCart = () => {
  router.push('/cart')
}
</script>

<style scoped>
.payment-result__card {
  text-align: center;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.payment-result__icon {
  font-size: 80px;
  margin-bottom: 20px;
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
}

.payment-result__actions {
  margin-top: 20px;
}
</style>