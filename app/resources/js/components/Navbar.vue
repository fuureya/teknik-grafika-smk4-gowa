<template>
    <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="@/assets/tg.png" alt="Logo" class="w-12 h-12">
                <span class="text-xl font-bold text-gray-800 tracking-wide">SMKN 4 GOWA</span>
            </div>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex items-center space-x-8 text-gray-700 font-semibold">
                <li>
                    <Link href="/" class="hover:text-blue-600 transition-colors duration-300">
                        Home
                    </Link>
                </li>
                <!-- About Us Dropdown -->
                <li class="relative">
                    <button @click.stop="toggleDropdown('aboutUs')" class="cursor-pointer flex items-center gap-1 hover:text-blue-600 transition-colors duration-300">
                        About Us
                    </button>
                    <ul class="absolute left-0 mt-2 w-56 bg-white text-gray-700 rounded-lg shadow-xl transform transition-all duration-300"
                        :class="{ 'opacity-100 translate-y-1 pointer-events-auto': openDropdown === 'aboutUs', 'opacity-0 pointer-events-none': openDropdown !== 'aboutUs' }">
                        <li v-for="item in aboutUs" :key="item.to">
                            <Link :href="item.to" class="block px-4 py-3 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors" @click="closeDropdown">
                                {{ item.name }}
                            </Link>
                        </li>
                    </ul>
                </li>

                <!-- Loca Club Dropdown -->
                <li class="relative">
                    <button @click.stop="toggleDropdown('locaClub')" class="cursor-pointer flex items-center gap-1 hover:text-blue-600 transition-colors duration-300">
                        Loca Club
                    </button>
                    <ul class="absolute left-0 mt-2 w-48 bg-white text-gray-700 rounded-lg shadow-xl transform transition-all duration-300"
                        :class="{ 'opacity-100 translate-y-1 pointer-events-auto': openDropdown === 'locaClub', 'opacity-0 pointer-events-none': openDropdown !== 'locaClub' }">
                        <li v-for="item in locaClub" :key="item.to">
                            <Link :href="item.to" class="block px-4 py-3 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors" @click="closeDropdown">
                                {{ item.name }}
                            </Link>
                        </li>
                    </ul>
                </li>

                <!-- Loca Graf Dropdown -->
                <li class="relative">
                    <button @click.stop="toggleDropdown('locaGraf')" class="cursor-pointer flex items-center gap-1 hover:text-blue-600 transition-colors duration-300">
                        Loca Graf
                    </button>
                    <ul class="absolute left-0 mt-2 w-48 bg-white text-gray-700 rounded-lg shadow-xl transform transition-all duration-300"
                        :class="{ 'opacity-100 translate-y-1 pointer-events-auto': openDropdown === 'locaGraf', 'opacity-0 pointer-events-none': openDropdown !== 'locaGraf' }">
                        <li v-for="item in locaGraf" :key="item.to">
                            <Link :href="item.to" class="block px-4 py-3 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors" @click="closeDropdown">
                                {{ item.name }}
                            </Link>
                        </li>
                    </ul>
                </li>

                <!-- Contact -->
                <li>
                    <Link href="/contact" class="hover:text-blue-600 transition-colors duration-300">
                        Contact
                    </Link>
                </li>
            </ul>

            <!-- Mobile Menu Button -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-700 focus:outline-none text-2xl">
                ☰
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <transition name="slide-fade">
            <div v-if="mobileOpen" @click="mobileOpen = false" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm md:hidden">
                <div @click.stop class="bg-white w-full absolute top-0 shadow-lg">
                    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-800">Menu</span>
                        <button @click="mobileOpen = false" class="text-gray-700 focus:outline-none text-3xl">&times;</button>
                    </div>
                    <div class="px-6 pb-6 space-y-4">
                        <Link href="/" class="block font-semibold text-lg hover:text-blue-600" @click="mobileOpen = false">
                            Home
                        </Link>
                        <div>
                            <p class="font-bold text-lg text-gray-800">About Us</p>
                            <ul class="pl-4 mt-2 space-y-3">
                                <li v-for="item in aboutUs" :key="item.to">
                                    <Link :href="item.to" class="block hover:text-blue-600" @click="mobileOpen = false">
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-bold text-lg text-gray-800">Loca Club</p>
                            <ul class="pl-4 mt-2 space-y-3">
                                <li v-for="item in locaClub" :key="item.to">
                                    <Link :href="item.to" class="block hover:text-blue-600" @click="mobileOpen = false">
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <p class="font-bold text-lg text-gray-800">Loca Graf</p>
                            <ul class="pl-4 mt-2 space-y-3">
                                <li v-for="item in locaGraf" :key="item.to">
                                    <Link :href="item.to" class="block hover:text-blue-600" @click="mobileOpen = false">
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <Link href="/contact" class="block font-semibold text-lg hover:text-blue-600" @click="mobileOpen = false">
                            Contact
                        </Link>
                    </div>
                </div>
            </div>
        </transition>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from "vue"
import { Link } from '@inertiajs/vue3';

const mobileOpen = ref(false)
const openDropdown = ref(null)

watch(mobileOpen, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

const toggleDropdown = (name) => {
    if (openDropdown.value === name) {
        openDropdown.value = null;
    } else {
        openDropdown.value = name;
    }
}

const closeDropdown = () => {
    openDropdown.value = null;
}

onMounted(() => {
    window.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
    window.removeEventListener('click', closeDropdown)
    document.body.style.overflow = ''; // Ensure style is reset on component unmount
})

const aboutUs = [
    { name: "Visi Misi", to: "/visi-misi" },
    { name: "Struktur Organisasi", to: "/struktur" },
    { name: "Kurikulum", to: "/kurikulum" },
]

const locaClub = [
    { name: "News", to: "/news" },
    { name: "Gallery", to: "/gallery" },
]

const locaGraf = [
    { name: "Produk", to: "/produk" },
    { name: "E-Card", to: "/ecard" },
]
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-from .bg-white,
.slide-fade-leave-to .bg-white {
    transform: translateY(-100%);
}
</style>