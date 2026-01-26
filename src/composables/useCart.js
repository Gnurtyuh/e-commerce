import { ref, computed } from "vue";

// ================== STATE ==================
// Danh sách sản phẩm trong giỏ hàng (dùng chung toàn app)
const cartItems = ref([]);

// ================== LOAD CART ==================
// Load cart từ localStorage khi khởi tạo
if (typeof window !== "undefined") {
  const savedCart = localStorage.getItem("ogani-cart");
  if (savedCart) {
    try {
      cartItems.value = JSON.parse(savedCart);
    } catch (e) {
      console.error("Không thể parse giỏ hàng từ localStorage", e);
    }
  }
}

// ================== SAVE CART ==================
function saveCart() {
  if (typeof window !== "undefined") {
    localStorage.setItem("ogani-cart", JSON.stringify(cartItems.value));
  }
}

// ================== COMPOSABLE ==================
export function useCart() {
  // Tổng số lượng sản phẩm trong giỏ
  const cartCount = computed(() =>
    cartItems.value.reduce((total, item) => total + item.quantity, 0),
  );

  // Tổng tiền (chưa format)
  const cartTotal = computed(() =>
    cartItems.value.reduce(
      (total, item) => total + item.price * item.quantity,
      0,
    ),
  );

  // Tổng tiền (đã format VNĐ)
  const cartTotalFormatted = computed(() => formatVND(cartTotal.value));

  // ================== ACTIONS ==================

  // Thêm sản phẩm vào giỏ
  function addToCart(product, quantity = 1) {
    const existingItem = cartItems.value.find((item) => item.id === product.id);

    if (existingItem) {
      existingItem.quantity += quantity;
    } else {
      cartItems.value.push({
        ...product,
        quantity,
      });
    }

    saveCart();
  }

  // Xoá sản phẩm khỏi giỏ
  function removeFromCart(productId) {
    cartItems.value = cartItems.value.filter((item) => item.id !== productId);
    saveCart();
  }

  // Cập nhật số lượng
  function updateQuantity(productId, quantity) {
    const item = cartItems.value.find((item) => item.id === productId);

    if (!item) return;

    if (quantity <= 0) {
      removeFromCart(productId);
    } else {
      item.quantity = quantity;
      saveCart();
    }
  }

  // Xoá toàn bộ giỏ hàng
  function clearCart() {
    cartItems.value = [];
    saveCart();
  }

  return {
    cartItems,
    cartCount,
    cartTotal,
    cartTotalFormatted,
    addToCart,
    removeFromCart,
    updateQuantity,
    clearCart,
  };
}

// ================== UTILS ==================
function formatVND(value) {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(value);
}
