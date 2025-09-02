<script setup>
import { ref } from "vue";
import cardBg from "@/assets/card.png"; // background depan
import cardBg2 from "@/assets/card2.png"; // background belakang
import html2canvas from "html2canvas"; // install: npm install html2canvas

const form = ref({
    nrg: "",
    nama: "",
    peserta: "",
    sertifikat: "",
    tahun: "",
    mapel: "",
    photo: null,
});

const photoUrl = ref(null);
const cardFrontRef = ref(null); // untuk cetak depan
const cardBackRef = ref(null); // untuk cetak belakang

const handlePhotoUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.value.photo = file;
        photoUrl.value = URL.createObjectURL(file);
    }
};

const resetForm = () => {
    form.value = {
        nrg: "",
        nama: "",
        peserta: "",
        sertifikat: "",
        tahun: "",
        mapel: "",
        photo: null,
    };
    photoUrl.value = null;
};

// 📸 Export as JPG
const exportCard = async (refElement, filename) => {
    if (!refElement.value) return;
    const canvas = await html2canvas(refElement.value, {
        useCORS: true,
        backgroundColor: null,
    });
    const imgData = canvas.toDataURL("image/jpeg", 1.0);

    const link = document.createElement("a");
    link.href = imgData;
    link.download = filename;
    link.click();
};

const cetakDepan = () => {
    exportCard(
        cardFrontRef,
        `kartu_nrg_depan_${form.value.nama || "user"}.jpg`
    );
};

const cetakBelakang = () => {
    exportCard(
        cardBackRef,
        `kartu_nrg_belakang_${form.value.nama || "user"}.jpg`
    );
};
</script>

<template>
    <main class="bg-gray-50 min-h-screen px-4 md:px-16 py-12">
        <!-- Title + Instructions -->
        <div class="max-w-4xl mx-auto text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                Selamat Datang Di e-Kartu Cetak NRG
            </h1>
            <p class="text-gray-600 text-sm md:text-base mb-4">
                Pastikan NRG masih aktif dan terdaftar di Pusat Data dan Informasi
                Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi sebelum mencetak
                kartu.
            </p>
            <p class="text-gray-600 text-sm md:text-base mb-2">
                Berikut yang perlu disiapkan sebelum mulai mengisi Formulir:
            </p>
            <ol class="text-left text-gray-700 text-sm md:text-base list-decimal list-inside space-y-1">
                <li>NRG</li>
                <li>Nama Lengkap</li>
                <li>Nomor Peserta</li>
                <li>Nomor Sertifikat</li>
                <li>Tahun Lulus</li>
                <li>Mapel / Bidang Tugas</li>
                <li>File Foto 2x3 (PNG/JPG/JPEG)</li>
            </ol>
        </div>

        <!-- Form & Preview -->
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
            <!-- Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="bg-blue-600 text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-6 text-lg font-semibold">
                    Form Isian
                </h2>

                <div class="space-y-4">
                    <input v-model="form.nrg" type="text" placeholder="NRG (16 Digit)"
                        class="w-full border rounded p-2" />
                    <input v-model="form.nama" type="text" placeholder="Nama Lengkap"
                        class="w-full border rounded p-2" />
                    <input v-model="form.peserta" type="text" placeholder="Nomor Peserta"
                        class="w-full border rounded p-2" />
                    <div class="flex gap-4">
                        <input v-model="form.sertifikat" type="text" placeholder="Nomor Sertifikat"
                            class="flex-1 border rounded p-2" />
                        <input v-model="form.tahun" type="text" placeholder="Tahun" class="w-24 border rounded p-2" />
                    </div>
                    <input v-model="form.mapel" type="text" placeholder="Mapel / Bidang Tugas"
                        class="w-full border rounded p-2" />
                    <input type="file" @change="handlePhotoUpload" accept="image/*" class="w-full" />
                    <p class="text-xs text-red-500">
                        File Pas Photo | 2x3 | Format (.jpg/.jpeg/.png)
                    </p>
                </div>

                <div class="mt-6">
                    <button @click="resetForm" class="px-4 py-2 bg-gray-600 text-white rounded">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="bg-blue-600 text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-6 text-lg font-semibold">
                    Live Preview Kartu NRG
                </h2>

                <div class="space-y-4">
                    <!-- Card Depan -->
                    <div ref="cardFrontRef"
                        class="relative border rounded-lg overflow-hidden w-full h-64 bg-cover bg-center"
                        :style="{ backgroundImage: `url(${cardBg})` }">
                        <!-- Overlay -->
                        <div class="absolute inset-0 flex flex-col p-4 text-sm text-gray-900">
                            <div class="flex gap-4">
                                <!-- Photo -->
                                <div
                                    class="w-24 h-28 bg-gray-200 flex items-center justify-center overflow-hidden rounded shadow">
                                    <img v-if="photoUrl" :src="photoUrl" class="w-full h-full object-cover" />
                                    <span v-else class="text-gray-400 text-xs">Foto</span>
                                </div>

                                <!-- Text Info -->
                                <div class="text-sm space-y-1">
                                    <p><strong>NRG:</strong> {{ form.nrg }}</p>
                                    <p><strong>Nama:</strong> {{ form.nama }}</p>
                                    <p><strong>No. Peserta:</strong> {{ form.peserta }}</p>
                                    <p><strong>No. Sertifikat:</strong> {{ form.sertifikat }}</p>
                                    <p><strong>Tahun Lulus:</strong> {{ form.tahun }}</p>
                                    <p><strong>Mapel:</strong> {{ form.mapel }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Belakang -->
                <div class="space-y-4 mt-5">
                    <div ref="cardBackRef"
                        class="relative border rounded-lg overflow-hidden w-full h-64 bg-cover bg-center"
                        :style="{ backgroundImage: `url(${cardBg2})` }"></div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button @click="cetakDepan" class="px-4 py-2 bg-green-600 text-white rounded">
                            Cetak Depan
                        </button>
                        <button @click="cetakBelakang" class="px-4 py-2 bg-blue-600 text-white rounded">
                            Cetak Belakang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
