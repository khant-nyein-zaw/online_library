import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/HomePage.vue";
import BookList from "@/views/BookList.vue";
import BookDetails from "@/views/BookDetails.vue";
import CategoryList from "@/views/CategoryList.vue";

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
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
