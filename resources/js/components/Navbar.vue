<template>
    <nav :class="[
        'fixed top-0 left-0 w-full z-50 transition-all duration-300',
        'backdrop-blur-md',
        scrolled ? 'bg-white/50 shadow-lg' : 'bg-white'
    ]">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="text-2xl font-bold tracking-wide">
                <img src="@/assets/tg.png" alt="" class="w-12">
            </div>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex space-x-6 text-blue-600 font-semibold">
                <!-- About Us Dropdown -->
                <li class="relative group">
                    <button class="cursor-pointer flex items-center gap-1">About Us ▾</button>
                    <ul
                        class="absolute left-0 mt-2 w-56 bg-white text-blue-600 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:translate-y-1 transform transition-all duration-200 pointer-events-auto">
                        <li v-for="item in aboutUs" :key="item.to">
                            <Link :href="item.to" class="block px-4 py-2 hover:bg-blue-100 rounded-lg transition">
                                {{ item.name }}
                            </Link>
                        </li>
                    </ul>
                </li>

                <!-- Loca Club Dropdown -->
                <li class="relative group">
                    <button class="cursor-pointer flex items-center gap-1">Loca Club ▾</button>
                    <ul
                        class="absolute left-0 mt-2 w-40 bg-white text-blue-600 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:translate-y-1 transform transition-all duration-200 pointer-events-auto">
                        <li v-for="item in locaClub" :key="item.to">
                            <Link :href="item.to" class="block px-4 py-2 hover:bg-blue-100 rounded-lg transition">
                                {{ item.name }}
                            </Link>
                        </li>
                    </ul>
                </li>

                <!-- Loca Graf Dropdown -->
                <li class="relative group">
                    <button class="cursor-pointer flex items-center gap-1">Loca Graf ▾</button>
                    <ul
                        class="absolute left-0 mt-2 w-40 bg-white text-blue-600 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:translate-y-1 transform transition-all duration-200 pointer-events-auto">
                        <li v-for="item in locaGraf" :key="item.to">
                            <Link :href="item.to" class="block px-4 py-2 hover:bg-blue-100 rounded-lg transition">
                                {{ item.name }}
                            </Link>
                        </li>
                    </ul>
                </li>

                <!-- Contact -->
                <li>
                    <Link href="/contact" class="hover:text-blue-400 transition">
                        Contact
                    </Link>
                </li>
            </ul>

            <!-- Mobile Menu Button -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-blue-600 focus:outline-none">
                ☰
            </button>
        </div>

        <!-- Mobile Menu -->
        <div v-if="mobileOpen" class="md:hidden bg-white/80 text-blue-600 px-6 py-4 space-y-4 backdrop-blur-md">
            <div>
                <p class="font-semibold">About Us</p>
                <ul class="pl-4 space-y-2">
                    <li v-for="item in aboutUs" :key="item.to">
                        <Link :href="item.to" class="block hover:text-blue-400">
                            {{ item.name }}
                        </Link>
                    </li>
                </ul>
            </div>

            <div>
                <p class="font-semibold">Loca Club</p>
                <ul class="pl-4 space-y-2">
                    <li v-for="item in locaClub" :key="item.to">
                        <Link :href="item.to" class="block hover:text-blue-400">
                            {{ item.name }}
                        </Link>
                    </li>
                </ul>
            </div>

            <div>
                <p class="font-semibold">Loca Graf</p>
                <ul class="pl-4 space-y-2">
                    <li v-for="item in locaGraf" :key="item.to">
                        <Link :href="item.to" class="block hover:text-blue-400">
                            {{ item.name }}
                        </Link>
                    </li>
                </ul>
            </div>

            <Link href="/contact" class="block font-semibold hover:text-blue-400">
                Contact
            </Link>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue"
import { Link } from '@inertiajs/vue3';

const mobileOpen = ref(false)
const scrolled = ref(false)

const aboutUs = [
    { name: "Home", to: "/" },
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

const handleScroll = () => {
    scrolled.value = window.scrollY > 20
}

onMounted(() => window.addEventListener("scroll", handleScroll))
onUnmounted(() => window.removeEventListener("scroll", handleScroll))
</script>