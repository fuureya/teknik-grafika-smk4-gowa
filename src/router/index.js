import ContactPage from "@/page/ContactPage.vue";
import GalleryPage from "@/page/GalleryPage.vue";
import HomePage from "@/page/HomePage.vue";
import KurikulumPage from "@/page/KurikulumPage.vue";
import NewsPage from "@/page/NewsPage.vue";
import ProductPage from "@/page/ProductPage.vue";
import StrukturPage from "@/page/StrukturPage.vue";
import VisiMisiPage from "@/page/VisiMisiPage.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: "/", component: HomePage },
    { path: "/contact", component: ContactPage },
    { path: "/visi-misi", component: VisiMisiPage },
    { path: "/kurikulum", component: KurikulumPage },
    { path: "/struktur", component: StrukturPage },
    { path: "/produk", component: ProductPage },
    { path: "/gallery", component: GalleryPage },
    { path: "/news", component: NewsPage },
  ],
});

export default router;
