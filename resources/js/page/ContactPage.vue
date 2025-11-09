<script setup>
import Footer from '@/components/Footer.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Navbar from '@/components/Navbar.vue';

const contacts = [
    {
        name: "Instagram",
        icon: "📸",
        link: "https://instagram.com/username",
        colorFrom: "from-blue-400",
        colorTo: "to-blue-700",
    },
    {
        name: "Email",
        icon: "✉️",
        link: "mailto:example@email.com",
        colorFrom: "from-blue-400",
        colorTo: "to-blue-700",
    },
    {
        name: "WhatsApp",
        icon: "💬",
        link: "https://wa.me/1234567890",
        colorFrom: "from-blue-400",
        colorTo: "to-blue-700",
    },
    {
        name: "Facebook",
        icon: "📘",
        link: "https://facebook.com/username",
        colorFrom: "from-blue-400",
        colorTo: "to-blue-700",
    },
];
</script>

<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white flex flex-col items-center px-4 py-16 space-y-12">
        <h1 class="text-4xl font-bold text-blue-800 mb-8">Kontak Kami</h1>
        <p class="text-gray-600 max-w-2xl text-center mb-12">
            Silakan hubungi kami melalui salah satu platform di bawah ini. Kami senang mendengar dari Anda!
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 w-full max-w-6xl">
            <a v-for="contact in contacts" :key="contact.name" :href="contact.link" target="_blank"
                class="rounded-xl shadow-lg transform transition duration-500 hover:scale-105 hover:shadow-2xl text-white p-6 flex flex-col items-center justify-center bg-gradient-to-br"
                :class="[contact.colorFrom, contact.colorTo]">
                <div class="text-6xl mb-4">{{ contact.icon }}</div>
                <h2 class="text-xl font-bold mb-2">{{ contact.name }}</h2>
                <p class="text-sm text-white/90 text-center">
                    Klik untuk menghubungi kami melalui {{ contact.name }}
                </p>
            </a>
        </div>
    </div>

    <Footer />
</template>
