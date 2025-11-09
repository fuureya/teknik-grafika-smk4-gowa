<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    news: Object,
    previous: Object,
    next: Object,
    recommended: Array,
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
</script>

<template>
    <Head :title="news.judul" />
    <Navbar />
    <Jumbotron />

    <div class="bg-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="text-center">
                        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl break-words">
                            {{ news.judul }}
                        </h1>
                        <p class="mt-3 text-base text-gray-500">
                            Diterbitkan pada {{ formatDate(news.created_at) }}
                        </p>
                    </div>

                    <div class="mt-10">
                        <img class="w-full rounded-lg shadow-lg" :src="`/storage/${news.cover_berita}`" :alt="news.judul">
                    </div>

                    <div class="mt-8 prose prose-lg text-gray-500 mx-auto break-words" v-html="news.isi_berita">
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-12 flex justify-between">
                        <Link v-if="previous" :href="`/news/${previous.id}`" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            &laquo; Berita Sebelumnya
                        </Link>
                        <div v-else></div> <!-- Placeholder for alignment -->
                        <Link v-if="next" :href="`/news/${next.id}`" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Berita Selanjutnya &raquo;
                        </Link>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="mt-12 lg:mt-0 lg:col-span-1">
                    <div class="sticky top-4">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Rekomendasi Berita</h2>
                        <ul class="space-y-4">
                            <li v-for="(recNews, index) in recommended" :key="recNews.id" :class="{'border-b pb-4 border-gray-200': index < recommended.length - 1}">
                                <Link :href="`/news/${recNews.id}`" class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-100 transition">
                                    <img class="h-16 w-16 rounded-md object-cover" :src="`/storage/${recNews.cover_berita}`" :alt="recNews.judul">
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-800 break-words">{{ recNews.judul }}</h3>
                                        <p class="text-sm text-gray-500">{{ formatDate(recNews.created_at) }}</p>
                                    </div>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>
