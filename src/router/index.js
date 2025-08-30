import ContactPage from "@/page/ContactPage.vue";
import HomePage from "@/page/HomePage.vue";
import KurikulumPage from "@/page/KurikulumPage.vue";
import NewsPage from "@/page/NewsPage.vue";
import VisiMisiPage from "@/page/VisiMisiPage.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: "/", component: HomePage },
    { path: "/contact", component: ContactPage },
    { path: "/visi-misi", component: VisiMisiPage },
    { path: "/kurikulum", component: KurikulumPage },
    { path: "/news", component: NewsPage },
  ],
});

export default router;
