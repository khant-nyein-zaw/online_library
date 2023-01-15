import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "@/views/DashboardPage.vue";
import Books from "@/views/BooksPage.vue";
import IssueBook from "@/views/IssueBookPage.vue";
import Shelf from "@/views/ShelfPage.vue";

const routes = [
  {
    path: "/",
    name: "Dashboard",
    component: Dashboard,
  },
  {
    path: "/books",
    name: "Books",
    component: Books,
  },
  {
    path: "/issue-book",
    name: "IssueBook",
    component: IssueBook,
  },
  {
    path: "/shelf",
    name: "Shelf",
    component: Shelf,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
