<template>
    <AuthenticatedLayout>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Quick Start</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card: Kelola Product -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <span class="text-4xl mr-4">📦</span>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700">Kelola Product</h2>
                        <p class="text-gray-500 mt-1">Atur dan tambahkan produk baru.</p>
                    </div>
                </div>
                <Link href="/admin/products" class="inline-block mt-4 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                    Go to Products
                </Link>
            </div>

            <!-- Card: Kelola Berita -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <span class="text-4xl mr-4">📰</span>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700">Kelola Berita</h2>
                        <p class="text-gray-500 mt-1">Tulis dan publikasikan berita terkini.</p>
                    </div>
                </div>
                <Link href="/admin/news" class="inline-block mt-4 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                    Go to News
                </Link>
            </div>

            <!-- Card: Kelola Gallery -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center">
                    <span class="text-4xl mr-4">🖼️</span>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700">Kelola Gallery</h2>
                        <p class="text-gray-500 mt-1">Unggah dan kelola gambar galeri.</p>
                    </div>
                </div>
                <Link href="/admin/gallery" class="inline-block mt-4 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                    Go to Gallery
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<style>
/* We can add a global background color for the dashboard area if needed */
body {
    background-color: #f4f7f6;
}
</style>