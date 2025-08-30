<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import { ref } from 'vue';

const galleryImages = [
    "https://picsum.photos/500/300?random=1",
    "https://picsum.photos/300/500?random=2",
    "https://picsum.photos/400/400?random=3",
    "https://picsum.photos/450/300?random=4",
    "https://picsum.photos/300/450?random=5",
    "https://picsum.photos/500/350?random=6",
    "https://picsum.photos/350/500?random=7",
    "https://picsum.photos/400/600?random=8",
    "https://picsum.photos/600/400?random=9"
];

const visibleGallery = ref(Array(galleryImages.length).fill(false));

// Lightbox
const lightboxOpen = ref(false);
const currentImage = ref(0);

const openLightbox = (index) => {
    currentImage.value = index;
    lightboxOpen.value = true;
};

const nextImage = () => {
    currentImage.value = (currentImage.value + 1) % galleryImages.length;
};

const prevImage = () => {
    currentImage.value = (currentImage.value - 1 + galleryImages.length) % galleryImages.length;
};

const closeLightbox = () => {
    lightboxOpen.value = false;
};
</script>

<template>
    <Navbar />
    <Jumbotron />

    <!-- Gallery -->
    <div class="min-h-screen">
        <h1 class="text-4xl font-bold text-blue-800 text-center mb-12">Gallery</h1>

        <div class="columns-1 sm:columns-2 md:columns-3 gap-4 space-y-4 px-2">
            <div v-for="(img, index) in galleryImages" :key="index"
                class="break-inside-avoid rounded-xl overflow-hidden transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl cursor-pointer"
                v-intersect.once="visibleGallery[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleGallery[index] }" @click="openLightbox(index)">
                <img :src="img" alt="Gallery Image" class="w-full object-cover mb-2">
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div v-if="lightboxOpen" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50">
        <button @click="closeLightbox" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
        <button @click="prevImage" class="absolute left-4 text-white text-3xl font-bold">&lt;</button>
        <img :src="galleryImages[currentImage]" class="max-h-[90%] max-w-[90%] object-contain rounded-lg">
        <button @click="nextImage" class="absolute right-4 text-white text-3xl font-bold">&gt;</button>
    </div>

    <Footer />
</template>
