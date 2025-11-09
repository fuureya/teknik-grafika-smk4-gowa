<template>
    <footer class="w-full bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white">
        <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-8">

            <!-- Kolom 1: Tentang Sekolah -->
            <div>
                <h3 class="text-xl font-bold mb-4">Tentang Sekolah</h3>
                <p class="text-blue-100 leading-relaxed text-sm md:text-base">
                    Sekolah kami berkomitmen untuk memberikan pendidikan terbaik dengan fokus pada karakter,
                    kreativitas, dan akademik.
                </p>
            </div>

            <!-- Kolom 2: Link Cepat -->
            <div>
                <h3 class="text-xl font-bold mb-4">Link Cepat</h3>
                <ul class="space-y-2 text-blue-100 text-sm md:text-base">
                    <li><router-link to="/" class="hover:text-white transition">Home</router-link></li>
                    <li><router-link to="/visi-misi" class="hover:text-white transition">Visi Misi</router-link></li>
                    <li><router-link to="/kurikulum" class="hover:text-white transition">Kurikulum</router-link></li>
                    <li><router-link to="/organisasi" class="hover:text-white transition">Organisasi</router-link></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak / Sosial Media -->
            <div>
                <h3 class="text-xl font-bold mb-4">Kontak Kami</h3>
                <p class="text-blue-100 text-sm md:text-base mb-2">
                    Jalan Pendidikan No. 123, Kota Sekolah
                </p>
                <p class="text-blue-100 text-sm md:text-base mb-2">
                    Email: info@myschool.com
                </p>
                <p class="text-blue-100 text-sm md:text-base mb-2">
                    Telp: (021) 12345678
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-blue-100 hover:text-white transition">FB</a>
                    <a href="#" class="text-blue-100 hover:text-white transition">IG</a>
                    <a href="#" class="text-blue-100 hover:text-white transition">TW</a>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="border-t border-blue-400 mt-8 pt-4 text-center text-blue-100 text-sm md:text-base">
            &copy; 2025 MySchool. All rights reserved.
        </div>
    </footer>
</template>

<script setup>
// Tidak ada logic khusus untuk footer ini, semuanya statis
</script>
