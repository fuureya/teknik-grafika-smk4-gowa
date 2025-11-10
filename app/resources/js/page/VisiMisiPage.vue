<script setup>
import Footer from '@/components/Footer.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Navbar from '@/components/Navbar.vue';
import { ref } from 'vue';

const visibleVision = ref(false);
const visibleMission = ref(false);
</script>

<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white flex flex-col items-center px-4 py-16 space-y-16">
        <h1 class="text-4xl font-bold text-blue-800 mb-8">Visi & Misi Sekolah</h1>

        <!-- Visi Card -->
        <div class="max-w-4xl w-full rounded-xl shadow-lg p-8 text-white bg-gradient-to-br from-blue-400 to-blue-700 transform transition duration-700 opacity-0"
            v-intersect.once="visibleVision = true" :class="{ 'opacity-100 translate-y-0': visibleVision }">
            <h2 class="text-2xl font-bold mb-4">Visi</h2>
            <p class="text-white/90 leading-relaxed text-base md:text-lg">
                Menjadi lembaga pendidikan unggul yang mengembangkan karakter, kreativitas, dan kompetensi akademik
                siswa secara seimbang, sehingga mampu bersaing di tingkat nasional maupun internasional.
            </p>
        </div>

        <!-- Misi Card -->
        <div class="max-w-4xl w-full rounded-xl shadow-lg p-8 text-white bg-gradient-to-br from-blue-400 to-blue-700 transform transition duration-700 opacity-0"
            v-intersect.once="visibleMission = true" :class="{ 'opacity-100 translate-y-0': visibleMission }">
            <h2 class="text-2xl font-bold mb-4">Misi</h2>
            <ul class="list-disc list-inside text-white/90 space-y-2 text-base md:text-lg">
                <li>Menyelenggarakan kurikulum yang inovatif dan sesuai kebutuhan abad 21.</li>
                <li>Mengembangkan kreativitas dan bakat siswa melalui program ekstrakurikuler yang variatif.</li>
                <li>Membina karakter siswa agar menjadi pribadi yang disiplin, berintegritas, dan bertanggung jawab.
                </li>
                <li>Mendorong prestasi akademik dan non-akademik melalui pembelajaran yang efektif dan inovatif.</li>
                <li>Meningkatkan kerjasama dengan masyarakat, alumni, dan stakeholder untuk kemajuan pendidikan.</li>
            </ul>
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
