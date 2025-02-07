import { createRouter, createWebHistory } from "vue-router";
import DashboardIndex from "../views/DashboardIndex.vue";
import LoginView from "@/views/LoginView.vue";
import RegisterView from "@/views/RegisterView.vue";
import NotFoundView from "@/views/NotFoundView.vue";
import PotIndex from "@/views/PotIndex.vue";
import TransactionIndex from "@/views/TransactionIndex.vue";
import BudgetIndex from "@/views/BudgetIndex.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "dashboard",
      component: DashboardIndex,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
    },
    {
      path: "/transactions",
      name: "transactions",
      component: TransactionIndex,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/budgets",
      name: "budgets",
      component: BudgetIndex,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/pots",
      name: "pots",
      component: PotIndex,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/recurring-bills",
      name: "recurring",
      component: LoginView,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: NotFoundView,
    },
  ],
});

export default router;
