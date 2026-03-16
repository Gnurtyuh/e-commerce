import { ref, computed } from "vue"
import {q} from "vue-router/dist/devtools-EWN81iOl.mjs";
// ================== STATE ==================
const cartItems = ref([])

// ================== LOAD CART ==================
if (typeof window !== "undefined") {

  const savedCart = localStorage.getItem("ogani-cart")

  if (savedCart) {
    try {
      cartItems.value = JSON.parse(savedCart)
    } catch (e) {
      console.error("Không parse được cart", e)
    }
  }
}

// ================== SAVE CART ==================
function saveCart() {
  localStorage.setItem("ogani-cart", JSON.stringify(cartItems.value))
}

// ================== COMPOSABLE ==================
export function useCart() {

  // ================== TOTAL ITEMS ==================
  const cartCount = computed(() =>
      cartItems.value.reduce(
          (total, item) => total + item.quantity,
          0
      )
  )

  // ================== TOTAL PRICE ==================
  const cartTotal = computed(() =>
      cartItems.value.reduce(
          (total, item) => total + item.price * item.quantity,
          0
      )
  )

  const cartTotalFormatted = computed(() =>
      formatVND(cartTotal.value)
  )

  // ================== ADD TO CART ==================
  function addToCart(product, quantity = 1) {

    const existingItem = cartItems.value.find(
        item => item.productId === product.productId
    )

    if (existingItem) {

      existingItem.quantity += quantity

    } else {

      cartItems.value.push({
        productId: product.productId,
        variantId: product.variantId,
        name: product.name,
        image: product.image,
        stock: product.stock,
        price: product.price,
        quantity
      })

    }

    saveCart()
  }

  // ================== REMOVE ==================
  function removeFromCart(productId) {

    cartItems.value =
        cartItems.value.filter(
            item => item.productId !== productId
        )

    saveCart()
  }

  // ================== UPDATE ==================
  function updateQuantity(productId, quantity) {

    const item =
        cartItems.value.find(
            item => item.productId === productId
        )

    if (!item) return

    if (quantity <= 0) {

      removeFromCart(productId)

    } else {

      item.quantity = quantity
      saveCart()

    }

  }

  // ================== CLEAR ==================
  function clearCart() {
    cartItems.value = []
    saveCart()
  }

  return {
    cartItems,
    cartCount,
    cartTotal,
    cartTotalFormatted,
    addToCart,
    removeFromCart,
    updateQuantity,
    clearCart
  }
}

// ================== FORMAT ==================
function formatVND(value) {

  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND"
  }).format(value)

}