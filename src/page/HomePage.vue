<script setup>
import Footer from '@/components/Footer.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

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

    <div class="min-h-screen bg-green-50 flex flex-col items-center justify-center px-4 py-16 space-y-16">

        <!-- Section 1: Kata Sambutan Ketua Jurusan -->
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-10 items-center">
            <!-- Kiri Gradient -->
            <div class="rounded-lg shadow-md h-96 bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 flex items-center justify-center text-white font-semibold text-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl opacity-0"
                v-intersect.once="visibleLeft1 = true" :class="{ 'opacity-100 translate-y-0': visibleLeft1 }">
                Foto Ketua Jurusan
            </div>
            <!-- Kanan Putih -->
            <div class="flex flex-col justify-center bg-white p-8 rounded-lg shadow-md transform transition duration-700 hover:-translate-y-2 hover:shadow-xl opacity-0"
                v-intersect.once="visibleRight1 = true" :class="{ 'opacity-100 translate-y-0': visibleRight1 }">
                <h2 class="text-3xl font-bold text-blue-700 mb-4">Kata Sambutan Ketua Jurusan</h2>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-4">
                    Assalamu’alaikum warahmatullahi wabarakatuh. Selamat datang di website resmi sekolah kami. Kami
                    selalu berkomitmen untuk memberikan pendidikan terbaik bagi seluruh siswa.
                </p>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-4">
                    Semoga melalui website ini, semua pihak dapat memperoleh informasi yang jelas mengenai kegiatan,
                    prestasi, dan program-program sekolah. Kami juga berharap ini menjadi sarana komunikasi yang efektif
                    antara sekolah dan masyarakat.
                </p>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                    Terima kasih atas kunjungan Anda. Semoga kita semua dapat bekerja sama untuk kemajuan pendidikan dan
                    karakter siswa.
                </p>
                <button
                    class="mt-6 self-start bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white px-6 py-2 rounded-lg transition">
                    Selengkapnya
                </button>
            </div>
        </div>

        <!-- Section 2: Visi Misi -->
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-10 items-center">
            <!-- Kiri Putih -->
            <div class="flex flex-col justify-center bg-white p-8 rounded-lg shadow-md transform transition duration-700 hover:-translate-y-2 hover:shadow-xl opacity-0"
                v-intersect.once="visibleLeft2 = true" :class="{ 'opacity-100 translate-y-0': visibleLeft2 }">
                <h2 class="text-3xl font-bold text-blue-800 mb-4">Visi Misi</h2>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-4">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab ipsum non eos quidem id ut soluta sunt
                    hic iste explicabo consectetur nobis...
                </p>
                <button
                    class="mt-6 self-start bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white px-6 py-2 rounded-lg transition">
                    Selengkapnya
                </button>
            </div>
            <!-- Kanan Gradient -->
            <div class="rounded-lg shadow-md h-96 bg-gradient-to-br bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 flex items-center justify-center text-white font-semibold text-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl opacity-0"
                v-intersect.once="visibleRight2 = true" :class="{ 'opacity-100 translate-y-0': visibleRight2 }">
                Visi Misi
            </div>
        </div>

        <!-- Section 3: Kurikulum -->
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-10 items-center">
            <!-- Kiri Gradient -->
            <div class="rounded-lg shadow-md h-96 bg-gradient-to-br bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 flex items-center justify-center text-white font-semibold text-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl opacity-0"
                v-intersect.once="visibleLeft3 = true" :class="{ 'opacity-100 translate-y-0': visibleLeft3 }">
                Kurikulum
            </div>
            <!-- Kanan Putih -->
            <div class="flex flex-col justify-center bg-white p-8 rounded-lg shadow-md transform transition duration-700 hover:-translate-y-2 hover:shadow-xl opacity-0"
                v-intersect.once="visibleRight3 = true" :class="{ 'opacity-100 translate-y-0': visibleRight3 }">
                <h2 class="text-3xl font-bold text-blue-800 mb-4">Kurikulum</h2>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-4">
                    Kurikulum kami dirancang untuk mengembangkan kemampuan akademik, kreativitas, dan karakter siswa
                    secara seimbang.
                </p>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                    Program-program pembelajaran mencakup mata pelajaran inti dan pengayaan untuk mempersiapkan siswa
                    menghadapi tantangan global.
                </p>
                <button
                    class="mt-6 self-start bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white px-6 py-2 rounded-lg transition">
                    Selengkapnya
                </button>
            </div>
        </div>

        <!-- Section 4: Organisasi -->
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-10 items-center">
            <!-- Kiri Putih -->
            <div class="flex flex-col justify-center bg-white p-8 rounded-lg shadow-md transform transition duration-700 hover:-translate-y-2 hover:shadow-xl opacity-0"
                v-intersect.once="visibleLeft4 = true" :class="{ 'opacity-100 translate-y-0': visibleLeft4 }">
                <h2 class="text-3xl font-bold text-blue-800 mb-4">Organisasi</h2>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base mb-4">
                    Struktur organisasi sekolah mencakup kepengurusan, staf pengajar, dan divisi-divisi yang mendukung
                    operasional sekolah.
                </p>
                <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                    Setiap divisi bertanggung jawab atas program-program pembelajaran, ekstrakurikuler, dan kegiatan
                    kemasyarakatan.
                </p>
                <button
                    class="mt-6 self-start bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white px-6 py-2 rounded-lg transition">
                    Selengkapnya
                </button>
            </div>
            <!-- Kanan Gradient -->
            <div class="rounded-lg shadow-md h-96 bg-gradient-to-br bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 flex items-center justify-center text-white font-semibold text-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl opacity-0"
                v-intersect.once="visibleRight4 = true" :class="{ 'opacity-100 translate-y-0': visibleRight4 }">
                Organisasi
            </div>
        </div>

    </div>

    <Footer />
</template>

<script>
export default {
    directives: {
        intersect: {
            mounted(el, binding) {
                const observer = new IntersectionObserver(
                    ([entry]) => {
                        if (entry.isIntersecting) {
                            binding.value = true;
                            observer.unobserve(el);
                        }
                    },
                    { threshold: 0.1 }
                );
                observer.observe(el);
            },
        },
    },
};
</script>
