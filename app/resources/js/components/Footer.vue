<template>
    <footer class="w-full bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white">
        <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-8">

            <!-- Kolom 1: Tentang Sekolah -->
            <div>
                <h3 class="text-xl font-bold mb-4 border-b-2 border-blue-400 pb-2">SMKN 4 GOWA</h3>
                <p class="text-blue-100 leading-relaxed text-sm md:text-base">
                    Pusat keunggulan pendidikan vokasi di bidang Teknik Grafika, mencetak generasi siap kerja, kreatif, dan berakhlak mulia.
                </p>
            </div>

            <!-- Kolom 2: Link Cepat -->
            <div>
                <h3 class="text-xl font-bold mb-4 border-b-2 border-blue-400 pb-2">Link Cepat</h3>
                <ul class="space-y-2 text-blue-100 text-sm md:text-base">
                    <li><Link href="/" class="hover:text-white transition-colors duration-300">Home</Link></li>
                    <li><Link href="/visi-misi" class="hover:text-white transition-colors duration-300">Visi Misi</Link></li>
                    <li><Link href="/kurikulum" class="hover:text-white transition-colors duration-300">Kurikulum</Link></li>
                    <li><Link href="/struktur" class="hover:text-white transition-colors duration-300">Struktur Organisasi</Link></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak -->
            <div>
                <h3 class="text-xl font-bold mb-4 border-b-2 border-blue-400 pb-2">Hubungi Kami</h3>
                <p class="text-blue-100 text-sm md:text-base mb-2 leading-relaxed">
                    Jl. Baso Dg Ngawing No 127 Kel Mangalli, Jl. Dirgantara No.12, Tetebatu, Pallangga, Kab. Gowa, Sulawesi Selatan 92161
                </p>
                <p class="text-blue-100 text-sm md:text-base mb-2">
                    Telepon: (0411) 842619
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-blue-100 hover:text-white transition-colors duration-300">FB</a>
                    <a href="#" class="text-blue-100 hover:text-white transition-colors duration-300">IG</a>
                    <a href="#" class="text-blue-100 hover:text-white transition-colors duration-300">YT</a>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="border-t border-blue-500 mt-8 py-6 text-center text-blue-200 text-sm">
            &copy; {{ currentYear }} smkn4gowa. All rights reserved.
        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const currentYear = new Date().getFullYear();
</script>
