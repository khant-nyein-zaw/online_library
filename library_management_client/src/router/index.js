import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/HomePage.vue";
import BookList from "@/views/BookList.vue";
import BookDetails from "@/views/BookDetails.vue";
import CategoryList from "@/views/CategoryList.vue";
import Login from "@/views/auth/LoginPage.vue";
import Register from "@/views/auth/RegisterPage.vue";
import store from "@/store";

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
  {
    path: "/details/:bookId",
    name: "BookDetails",
    component: BookDetails,
    props: true,
  },
  {
    path: "/categories",
    name: "CategoryList",
    component: CategoryList,
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.name !== "Login" && !store.state.authenticated) {
    next({ name: "Login" });
  } else {
    next();
  }
});

export default router;
