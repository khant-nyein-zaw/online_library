import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/HomePage.vue";
import BookList from "@/views/BookList.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    alias: "/home",
    component: Home,
  },
  {
    path: "/book-list",
    name: "BookList",
    component: BookList,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
