<script setup>
import { ref } from "vue";
import Footer from "@/components/Footer.vue";
import Jumbotron from "@/components/Jumbotron.vue";
import Navbar from "@/components/Navbar.vue";
import NrgPage from "./NrgPage.vue";
// You can later create NisnPage.vue and NuptPage.vue
// import NisnPage from "./NisnPage.vue";
// import NuptPage from "./NuptPage.vue";

const selected = ref(null); // "nrg" | "nisn" | "nupt"
</script>

<template>
    <Navbar />
    <Jumbotron />

    <!-- Selection Section -->
    <section class="bg-gray-50 py-12 px-4 md:px-16">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8">
                Pilih Jenis Cetak Kartu
            </h2>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- NRG Card -->
                <div @click="selected = 'nrg'"
                    class="cursor-pointer group border rounded-2xl shadow-md bg-white p-6 hover:shadow-lg transition transform hover:-translate-y-1"
                    :class="selected === 'nrg' ? 'ring-4 ring-blue-500' : ''">
                    <div class="flex flex-col items-center space-y-3">
                        <div
                            class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200">
                            <span class="text-2xl font-bold text-blue-600">NRG</span>
                        </div>
                        <h3 class="font-semibold text-lg">Cetak Kartu NRG</h3>
                        <p class="text-sm text-gray-600">
                            Untuk Guru bersertifikat dengan Nomor Registrasi Guru.
                        </p>
                    </div>
                </div>

                <!-- NISN Card -->
                <div @click="selected = 'nisn'"
                    class="cursor-pointer group border rounded-2xl shadow-md bg-white p-6 hover:shadow-lg transition transform hover:-translate-y-1"
                    :class="selected === 'nisn' ? 'ring-4 ring-green-500' : ''">
                    <div class="flex flex-col items-center space-y-3">
                        <div
                            class="w-16 h-16 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200">
                            <span class="text-2xl font-bold text-green-600">NISN</span>
                        </div>
                        <h3 class="font-semibold text-lg">Cetak Kartu NISN</h3>
                        <p class="text-sm text-gray-600">
                            Untuk Siswa dengan Nomor Induk Siswa Nasional.
                        </p>
                    </div>
                </div>

                <!-- NUPT Card -->
                <div @click="selected = 'nupt'"
                    class="cursor-pointer group border rounded-2xl shadow-md bg-white p-6 hover:shadow-lg transition transform hover:-translate-y-1"
                    :class="selected === 'nupt' ? 'ring-4 ring-purple-500' : ''">
                    <div class="flex flex-col items-center space-y-3">
                        <div
                            class="w-16 h-16 flex items-center justify-center rounded-full bg-purple-100 group-hover:bg-purple-200">
                            <span class="text-2xl font-bold text-purple-600">NUPT</span>
                        </div>
                        <h3 class="font-semibold text-lg">Cetak Kartu NUPT</h3>
                        <p class="text-sm text-gray-600">
                            Untuk Tenaga Pendidik dengan Nomor Unik Pendidik & Tenaga Kependidikan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Conditional Rendering -->
    <section class="py-12 px-4 md:px-16">
        <div class="max-w-6xl mx-auto">
            <NrgPage v-if="selected === 'nrg'" />
            <NrgPage v-if="selected === 'nisn'" />
            <NrgPage v-if="selected === 'nupt'" />

        </div>
    </section>

    <Footer />
</template>
