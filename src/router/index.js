import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/shop",
    name: "Shop",
    component: () => import("@/views/Shop.vue"),
  },
  {
    path: "/shop/:id",
    name: "ShopDetails",
    component: () => import("@/views/ShopDetails.vue"),
  },
  {
    path: "/cart",
    name: "ShoppingCart",
    component: () => import("@/views/ShoppingCart.vue"),
  },
  {
    path: "/checkout",
    name: "Checkout",
    component: () => import("@/views/Checkout.vue"),
  },
  {
    path: "/blog",
    name: "Blog",
    component: () => import("@/views/Blog.vue"),
  },
  {
    path: "/blog/:id",
    name: "BlogDetails",
    component: () => import("@/views/BlogDetails.vue"),
  },
  {
    path: "/contact",
    name: "Contact",
    component: () => import("@/views/Contact.vue"),
  },
  {
    path: "/login",
    name: "Login",
    component: () => import("@/views/Login.vue"),
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("@/views/Register.vue"),
  },
  {
    path: "/verify",
    name: "VerifyOtp",
    component: () => import("@/views/VerifyOtp.vue"),
  },
  {
    path: "/product/:id",
    component: () => import("@/views/ShopDetails.vue"),
  },
  {
    path: "/profile",
    component: () => import("@/views/Profile.vue"),
  },
  {
    path: "/change-password",
    component: () => import("@/views/ChangePassword.vue"),
  },
  {
    path: "/orders",
    component: () => import("@/views/OrderHistory.vue"),
  },
  {
    path: '/orders/:id',
    component: () => import('@/views/OrderDetails.vue'),
  },
  // router/index.js
  {
    path: '/payment-success',
    name: 'PaymentSuccess',
    component: () => import('@/views/PaymentSuccess.vue')
  },
  {
    path: '/payment-cancel',
    name: 'PaymentCancel',
    component: () => import('@/views/PaymentCancel.vue')
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  },
});

export default router;
