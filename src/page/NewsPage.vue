<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import { ref } from 'vue';

// Import gambar secara langsung
import exampleImg from '@/assets/example.jpg';

const newsItems = [
    {
        title: "Pameran Grafika Tahunan",
        date: "2025-09-01",
        description: "Sekolah kami mengadakan pameran karya siswa Teknik Grafika dengan berbagai tema kreatif dan inovatif.",
        image: exampleImg
    },
    {
        title: "Workshop Ilustrasi Digital",
        date: "2025-08-25",
        description: "Workshop ini bertujuan meningkatkan keterampilan ilustrasi digital siswa menggunakan software profesional.",
        image: exampleImg
    },
    {
        title: "Prestasi Lomba Desain Poster",
        date: "2025-08-15",
        description: "Siswa Teknik Grafika berhasil meraih juara pertama dalam lomba poster tingkat nasional.",
        image: exampleImg
    },
    {
        title: "Pelatihan Fotografi Profesional",
        date: "2025-08-10",
        description: "Siswa belajar teknik fotografi modern, komposisi, pencahayaan, dan editing untuk kebutuhan profesional.",
        image: exampleImg
    },
    {
        title: "Kolaborasi dengan Studio Animasi",
        date: "2025-08-05",
        description: "Program kolaborasi ini memberikan pengalaman siswa dalam pembuatan animasi 2D & 3D secara profesional.",
        image: exampleImg
    },
    {
        title: "Eksperimen Desain Interaktif",
        date: "2025-08-01",
        description: "Siswa melakukan eksperimen desain interaktif menggunakan media digital modern.",
        image: exampleImg
    }
];

const visibleNews = ref(Array(newsItems.length).fill(false));
</script>


<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white px-6 py-16">
        <h1 class="text-4xl font-bold text-blue-800 text-center mb-12">Berita Terbaru</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div v-for="(news, index) in newsItems" :key="index"
                class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl"
                v-intersect.once="visibleNews[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleNews[index] }">
                <img :src="news.image" alt="News Image" class="w-full h-48 object-cover">
                <div class="p-6 bg-gradient-to-br from-blue-400 to-blue-700 text-white">
                    <h2 class="text-xl font-bold mb-2">{{ news.title }}</h2>
                    <p class="text-white/80 text-sm mb-2">{{ news.date }}</p>
                    <p class="text-white/90 text-base">{{ news.description }}</p>
                </div>
            </div>
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
