<template>
    <div class="relative w-full h-screen overflow-hidden">
        <!-- Slides -->
        <div v-for="(slide, index) in slides" :key="index" class="absolute inset-0 transition-opacity duration-1000"
            :class="currentIndex.value === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            <img :src="slide.image" class="w-full h-full object-cover" />
            <div
                class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-center text-white px-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ slide.title }}</h1>
                <p class="text-lg md:text-2xl mb-6">{{ slide.subtitle }}</p>
                <button class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold">
                    Learn More
                </button>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <button @click="prevSlide"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
            ◀
        </button>
        <button @click="nextSlide"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
            ▶
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const currentIndex = ref(0)
const slides = [
    {
        image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80',
        title: 'Discover Nature',
        subtitle: 'Explore the beauty of the world around you',
    },
    {
        image: 'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1600&q=80',
        title: 'Urban Adventures',
        subtitle: 'Experience life in the bustling city',
    },
    {
        image: 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80',
        title: 'Mountain Escape',
        subtitle: 'Find peace in the mountains',
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

onMounted(() => {
    startAutoSlide()
})

onBeforeUnmount(() => {
    clearInterval(interval)
})
</script>
