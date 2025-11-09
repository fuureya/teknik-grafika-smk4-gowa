<script setup>
import Footer from '@/components/Footer.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

const visibleItems = ref([false, false, false, false, false]);

const curriculumItems = [
    {
        icon: "🎨",
        title: "Desain Grafis",
        description: "Mempelajari dasar-dasar desain visual, tipografi, warna, dan layout untuk menciptakan karya grafis yang efektif."
    },
    {
        icon: "🖌️",
        title: "Ilustrasi Digital",
        description: "Mengembangkan kemampuan menggambar dan ilustrasi menggunakan software digital populer seperti Adobe Illustrator dan Procreate."
    },
    {
        icon: "📐",
        title: "Percetakan & Produksi",
        description: "Belajar proses produksi grafika, mulai dari persiapan file hingga pencetakan akhir dengan standar industri."
    },
    {
        icon: "💻",
        title: "Multimedia & Animasi",
        description: "Menguasai animasi 2D dan 3D serta multimedia interaktif untuk keperluan promosi dan storytelling visual."
    },
    {
        icon: "🖼️",
        title: "Fotografi & Editing",
        description: "Teknik fotografi profesional serta pengolahan foto menggunakan perangkat lunak editing untuk kebutuhan publikasi."
    }
];
</script>

<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white px-4 py-16 flex flex-col items-center space-y-8">

        <h1 class="text-4xl font-bold text-blue-800 mb-8">Kurikulum Teknik Grafika</h1>

        <div class="w-full max-w-4xl flex flex-col space-y-6">
            <div v-for="(item, index) in curriculumItems" :key="index"
                class="flex items-start space-x-4 p-6 bg-gradient-to-br from-blue-400 to-blue-700 text-white rounded-xl shadow-lg transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl"
                v-intersect.once="visibleItems[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleItems[index] }">
                <div class="text-4xl flex-shrink-0">{{ item.icon }}</div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">{{ item.title }}</h2>
                    <p class="text-white/90 text-base md:text-lg">{{ item.description }}</p>
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
