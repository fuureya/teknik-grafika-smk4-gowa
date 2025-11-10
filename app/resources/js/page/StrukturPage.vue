<script setup>
import Footer from '@/components/Footer.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

// Import gambar Ketua Jurusan
import gambarKetua from '@/assets/gambar1.webp';

const visibleLeft1 = ref(false);
const visibleRight1 = ref(false);
const visibleLeft2 = ref(false);
const visibleRight2 = ref(false);
const visibleLeft3 = ref(false);
const visibleRight3 = ref(false);
const visibleLeft4 = ref(false);
const visibleRight4 = ref(false);
</script>

<template>
    <Navbar />
    <Jumbotron />


    <Footer />
</template>

<script>

</script>
