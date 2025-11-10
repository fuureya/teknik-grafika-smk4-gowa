<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    galleries: Array,
});

const visibleGallery = ref([]);

onMounted(() => {
    if (props.galleries) {
        visibleGallery.value = Array(props.galleries.length).fill(false);
    }
});

// Lightbox
const lightboxOpen = ref(false);
const currentImageIndex = ref(0);

const openLightbox = (index) => {
    currentImageIndex.value = index;
    lightboxOpen.value = true;
};

const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.galleries.length;
};

const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + props.galleries.length) % props.galleries.length;
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
            <div v-for="(gallery, index) in galleries" :key="gallery.id"
                class="break-inside-avoid rounded-xl overflow-hidden transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl cursor-pointer"
                v-intersect.once="visibleGallery[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleGallery[index] }" @click="openLightbox(index)">
                <img :src="`/storage/${gallery.image_path}`" :alt="gallery.caption || 'Gallery Image'" class="w-full object-cover mb-2">
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div v-if="lightboxOpen" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50" @click.self="closeLightbox">
        <button @click="closeLightbox" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
        <button @click="prevImage" class="absolute left-4 text-white text-3xl font-bold">&lt;</button>
        <div class="text-center">
            <img :src="`/storage/${galleries[currentImageIndex].image_path}`" class="max-h-[85vh] max-w-[90vw] object-contain rounded-lg">
            <p v-if="galleries[currentImageIndex].caption" class="text-white mt-4 text-lg">{{ galleries[currentImageIndex].caption }}</p>
        </div>
        <button @click="nextImage" class="absolute right-4 text-white text-3xl font-bold">&gt;</button>
    </div>

    <Footer />
</template>
