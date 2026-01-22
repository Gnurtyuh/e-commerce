import { ref, computed } from 'vue'

// Cart state (shared across all components)
const cartItems = ref([])

// Load cart from localStorage on initialization
if (typeof window !== 'undefined') {
    const savedCart = localStorage.getItem('ogani-cart')
    if (savedCart) {
        try {
            cartItems.value = JSON.parse(savedCart)
        } catch (e) {
            console.error('Failed to parse cart from localStorage', e)
        }
    }
}

// Save cart to localStorage
function saveCart() {
    if (typeof window !== 'undefined') {
        localStorage.setItem('ogani-cart', JSON.stringify(cartItems.value))
    }
}

export function useCart() {
    const cartCount = computed(() => {
        return cartItems.value.reduce((total, item) => total + item.quantity, 0)
    })

    const cartTotal = computed(() => {
        return cartItems.value.reduce((total, item) => total + (item.price * item.quantity), 0)
    })

    function addToCart(product, quantity = 1) {
        const existingItem = cartItems.value.find(item => item.id === product.id)

        if (existingItem) {
            existingItem.quantity += quantity
        } else {
            cartItems.value.push({
                ...product,
                quantity
            })
        }

        saveCart()
    }

    function removeFromCart(productId) {
        const index = cartItems.value.findIndex(item => item.id === productId)
        if (index !== -1) {
            cartItems.value.splice(index, 1)
            saveCart()
        }
    }

    function updateQuantity(productId, quantity) {
        const item = cartItems.value.find(item => item.id === productId)
        if (item) {
            if (quantity <= 0) {
                removeFromCart(productId)
            } else {
                item.quantity = quantity
                saveCart()
            }
        }
    }

    function clearCart() {
        cartItems.value = []
        saveCart()
    }

    return {
        cartItems,
        cartCount,
        cartTotal,
        addToCart,
        removeFromCart,
        updateQuantity,
        clearCart
    }
}
