<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import { ref } from 'vue';

// Import gambar produk
import exampleImg from '@/assets/example.jpg';

const products = [
    {
        title: "Cetak Poster Kreatif",
        code: "PRD001",
        description: "Produk poster dengan desain kreatif dan bahan berkualitas tinggi untuk promosi maupun dekorasi.",
        image: exampleImg
    },
    {
        title: "E-Card Digital",
        code: "PRD002",
        description: "Kartu digital interaktif untuk berbagai keperluan, mudah dibagikan dan ramah lingkungan.",
        image: exampleImg
    },
    {
        title: "Merchandise Sekolah",
        code: "PRD003",
        description: "Merchandise eksklusif seperti mug, tas, dan kaos dengan desain khas sekolah.",
        image: exampleImg
    },
    {
        title: "Kalender Desain Grafika",
        code: "PRD004",
        description: "Kalender dinding dengan ilustrasi karya siswa, cocok untuk dekorasi ruang kelas atau kantor.",
        image: exampleImg
    },
    {
        title: "Buku Karya Siswa",
        code: "PRD005",
        description: "Kumpulan karya grafika siswa dicetak dalam buku berkualitas, cocok untuk dokumentasi dan pameran.",
        image: exampleImg
    },
    {
        title: "Sticker & Label Custom",
        code: "PRD006",
        description: "Sticker dan label dengan desain kustom untuk branding atau hiasan pribadi.",
        image: exampleImg
    }
];

const visibleProducts = ref(Array(products.length).fill(false));
</script>

<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white px-6 py-16">
        <h1 class="text-4xl font-bold text-blue-800 text-center mb-12">Produk Terbaru</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div v-for="(product, index) in products" :key="index"
                class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl"
                v-intersect.once="visibleProducts[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleProducts[index] }">
                <img :src="product.image" alt="Product Image" class="w-full h-48 object-cover">
                <div class="p-6 bg-gradient-to-br from-blue-400 to-blue-700 text-white">
                    <h2 class="text-xl font-bold mb-1">{{ product.title }}</h2>
                    <p class="text-white/80 text-sm mb-2">{{ product.code }}</p>
                    <p class="text-white/90 text-base">{{ product.description }}</p>
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
