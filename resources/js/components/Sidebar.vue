<template>
    <aside :class="{'w-64': props.isOpen, 'w-16': !props.isOpen}"
           class="fixed top-0 left-0 h-screen transition-all duration-300 ease-in-out z-40" aria-label="Sidebar">
        <div class="overflow-y-auto py-4 px-3 h-screen bg-white text-gray-800 border-r border-gray-200 relative">
            <!-- Toggle Button -->
            <button @click="emit('toggle')"
                    class="absolute top-1/2 -translate-y-1/2 -right-3 p-1 rounded-full bg-blue-600 text-white shadow-md focus:outline-none z-50">
                <span v-if="props.isOpen" class="text-lg">◀</span>
                <span v-else class="text-lg">▶</span>
            </button>

            <!-- Logo -->
            <a href="/dashboard" class="flex items-center pl-2.5 mb-5" :class="{'justify-center': !props.isOpen}">
                <img src="@/assets/tg.png" class="h-12 w-auto" :class="{'mr-3': props.isOpen}" alt="Logo" />
                <span v-if="props.isOpen" class="self-center text-xl font-semibold whitespace-nowrap">Admin Panel</span>
            </a>
            
            <!-- Menu -->
            <ul class="mt-5">
                <li>
                    <Link href="/dashboard" class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-blue-100 text-gray-700 border-b border-gray-200 hover:border-dashed hover:border-blue-500">
                        <span class="text-xl">🏠</span>
                        <div v-if="props.isOpen" class="ml-3">
                            <span>Dashboard</span>
                            <span class="block text-xs text-gray-500">Halaman utama</span>
                        </div>
                    </Link>
                </li>
                <li>
                    <Link href="/admin/products" class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-blue-100 text-gray-700 border-b border-gray-200 hover:border-dashed hover:border-blue-500">
                        <span class="text-xl">📦</span>
                        <div v-if="props.isOpen" class="ml-3">
                            <span>Kelola Product</span>
                            <span class="block text-xs text-gray-500">Atur produk Anda</span>
                        </div>
                    </Link>
                </li>
                <li>
                    <Link href="/admin/news" class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-blue-100 text-gray-700 border-b border-gray-200 hover:border-dashed hover:border-blue-500">
                        <span class="text-xl">📰</span>
                        <div v-if="props.isOpen" class="ml-3">
                            <span>Kelola Berita</span>
                            <span class="block text-xs text-gray-500">Publikasi berita</span>
                        </div>
                    </Link>
                </li>
                <li>
                    <Link href="/admin/gallery" class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-blue-100 text-gray-700 border-b border-gray-200 hover:border-dashed hover:border-blue-500">
                        <span class="text-xl">🖼️</span>
                        <div v-if="props.isOpen" class="ml-3">
                            <span>Kelola Gallery</span>
                            <span class="block text-xs text-gray-500">Manajemen gambar</span>
                        </div>
                    </Link>
                </li>
                <li>
                    <Link href="/admin/users" class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-blue-100 text-gray-700 border-b border-gray-200 hover:border-dashed hover:border-blue-500">
                        <span class="text-xl">👥</span>
                        <div v-if="props.isOpen" class="ml-3">
                            <span>Kelola User</span>
                            <span class="block text-xs text-gray-500">Manajemen pengguna</span>
                        </div>
                    </Link>
                </li>
                 <li>
                    <Link href="/logout" method="post" as="button" type="button" class="w-full flex items-center p-2 text-base font-normal rounded-lg hover:bg-red-100 text-red-700 border-b border-gray-200 hover:border-dashed hover:border-red-500">
                        <span class="text-xl">🚪</span>
                        <div v-if="props.isOpen" class="ml-3 text-left">
                            <span>Logout</span>
                            <span class="block text-xs text-gray-500">Keluar dari sesi</span>
                        </div>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    isOpen: Boolean,
});

const emit = defineEmits(['toggle']);
</script>