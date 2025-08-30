import ContactPage from "@/page/ContactPage.vue";
import HomePage from "@/page/HomePage.vue";
import KurikulumPage from "@/page/KurikulumPage.vue";
import VisiMisiPage from "@/page/VisiMisiPage.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: "/", component: HomePage },
    { path: "/contact", component: ContactPage },
    { path: "/visi-misi", component: VisiMisiPage },
    { path: "/kurikulum", component: KurikulumPage },
  ],
});

export default router;
