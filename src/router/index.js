import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/LoginView.vue";

const routes = [
   {
      path: "/",
      name: "login",
      component: Login,
   },
   {
      path: "/member",
      name: "member",
      component: () => import("../views/MemberView.vue"),
   },
   {
      path: "/news",
      name: "news",
      component: () => import("../views/NewsView.vue"),
   },
   {
      path: "/history",
      name: "history",
      component: () => import("../views/HistoryView.vue"),
   },
   {
      path: "/itinerary",
      name: "itinerary",
      component: () => import("../views/ItineraryView.vue"),
   },
   {
      path: "/itineraryorder",
      name: "itineraryorder",
      component: () => import("../views/ItineraryOrderView.vue"),
   },
   {
      path: "/itinerarycanvas",
      name: "itinerarycanvas",
      component: () => import("../views/ItineraryCanvasView.vue"),
   },
   {
      path: "/itinerarycomment",
      name: "itinerarycomment",
      component: () => import("../views/ItineraryCommentView.vue"),
   },
   {
      path: "/product",
      name: "product",
      component: () => import("../views/ProductView.vue"),
   },
   {
      path: "/productorder",
      name: "productorder",
      component: () => import("../views/ProductOrderView.vue"),
   },
   {
      path: "/qa",
      name: "qa",
      component: () => import("../views/QAView.vue"),
   },
   {
      path: "/coupon",
      name: "coupon",
      component: () => import("../views/CouponView.vue"),
   },
   {
      path: "/backaccount",
      name: "backaccount",
      component: () => import("../views/BackAccountView.vue"),
   },
];

const router = createRouter({
   history: createWebHistory(process.env.BASE_URL),
   routes,
});

export default router;
