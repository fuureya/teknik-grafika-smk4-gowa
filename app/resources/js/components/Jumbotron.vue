<template>
    <div class="relative w-full h-screen overflow-hidden">
        <!-- Slides -->
        <div v-for="(slide, index) in slides" :key="index" class="absolute inset-0 transition-opacity duration-1000"
            :class="currentIndex === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            <img :src="slide.image" class="w-full h-full object-cover" />
            <div
                class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/60 flex flex-col justify-center items-center text-center text-white px-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">{{ slide.title }}</h1>
                <p class="text-lg md:text-2xl mb-6 max-w-3xl">{{ slide.subtitle }}</p>
                <button class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-lg font-semibold text-lg transition-transform transform hover:scale-105">
                    Jelajahi Jurusan
                </button>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <button @click="prevSlide"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 z-20">
            ◀
        </button>
        <button @click="nextSlide"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 z-20">
            ▶
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
// Import gambar agar bisa dipakai di :src
import exampleImg from '@/assets/example.jpg'
import cardImg from '@/assets/card.png'
import card2Img from '@/assets/card2.png'


const currentIndex = ref(0)
const slides = [
    {
        image: exampleImg,
        title: 'Selamat Datang di Teknik Grafika',
        subtitle: 'Tempat di mana kreativitas bertemu teknologi untuk membentuk masa depan desainer profesional.',
    },
    {
        image: cardImg,
        title: 'Siap Kerja di Industri Kreatif',
        subtitle: 'Kami membekali siswa dengan keahlian desain, cetak, dan media digital yang relevan dengan kebutuhan industri saat ini.',
    },
    {
        image: card2Img,
        title: 'Wujudkan Karyamu',
        subtitle: 'Dari konsep hingga hasil akhir, pelajari seluruh proses produksi grafika dengan fasilitas modern dan pembimbing ahli.',
    },
]

let interval = null

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % slides.length
}

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length
}

const startAutoSlide = () => {
    interval = setInterval(nextSlide, 5000) // auto slide setiap 5 detik
}

onMounted(() => startAutoSlide())
onBeforeUnmount(() => clearInterval(interval))
</script>
