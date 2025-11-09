<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import Pagination from '@/components/Pagination.vue';
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    news: Object,
});

const visibleNews = ref([]);

onMounted(() => {
    if (props.news && props.news.data) {
        visibleNews.value = Array(props.news.data.length).fill(false);
    }
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>


<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white px-6 py-16">
        <h1 class="text-4xl font-bold text-blue-800 text-center mb-12">Berita Terbaru</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div v-for="(newsItem, index) in news.data" :key="index"
                class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl"
                v-intersect.once="visibleNews[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleNews[index] }">
                <Link :href="`/news/${newsItem.id}`">
                    <img :src="`/storage/${newsItem.cover_berita}`" alt="News Image" class="w-full h-48 object-cover">
                    <div class="p-6 bg-gradient-to-br from-blue-400 to-blue-700 text-white">
                        <h2 class="text-xl font-bold mb-2">{{ newsItem.judul }}</h2>
                        <p class="text-white/80 text-sm mb-2">{{ formatDate(newsItem.created_at) }}</p>
                        <p class="text-white/90 text-base" v-html="newsItem.isi_berita.substring(0, 100) + '...'"></p>
                    </div>
                </Link>
            </div>
        </div>
        <div class="mt-8 flex justify-center">
            <Pagination :links="news.links" />
        </div>
    </div>

    <Footer />
</template>

<script>
export default {
    directives: {
        intersect: {
            mounted(el, binding) {
                const observer = new IntersectionObserver(
                    ([entry]) => {
                        if (entry.isIntersecting) {
                            binding.value = true;
                            observer.unobserve(el);
                        }
                    },
                    { threshold: 0.1 }
                );
                observer.observe(el);
            },
        },
    },
};
</script>
