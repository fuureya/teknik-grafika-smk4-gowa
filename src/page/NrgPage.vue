<script setup>
import { ref } from "vue";

const form = ref({
    nrg: "",
    nama: "",
    peserta: "",
    sertifikat: "",
    tahun: "",
    mapel: "",
    photo: null,
});

const handlePhotoUpload = (e) => {
    form.value.photo = e.target.files[0];
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
                Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi sebelum mencetak kartu.
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
                    <p class="text-xs text-red-500">File Pas Photo | 2x3 | Format (.jpg/.jpeg/.png)</p>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 bg-gray-600 text-white rounded">Reset</button>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="bg-blue-600 text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-6 text-lg font-semibold">
                    Live Preview Kartu NRG
                </h2>
                <div class="space-y-4">
                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gray-100 p-4 text-center text-sm text-gray-600">
                            KARTU SERTIFIKASI GURU <br /> No Sertifikat:
                            <span class="font-semibold">{{ form.sertifikat }}</span>
                        </div>
                        <div class="flex p-4 gap-4">
                            <div class="w-24 h-28 bg-gray-200 flex items-center justify-center overflow-hidden rounded">
                                <img v-if="form.photo" :src="URL.createObjectURL(form.photo)"
                                    class="w-full h-full object-cover" />
                                <span v-else class="text-gray-400 text-xs">Foto</span>
                            </div>
                            <div class="text-sm text-gray-700 space-y-1">
                                <p><strong>NRG:</strong> {{ form.nrg }}</p>
                                <p><strong>Nama:</strong> {{ form.nama }}</p>
                                <p><strong>No. Peserta:</strong> {{ form.peserta }}</p>
                                <p><strong>Tahun Lulus:</strong> {{ form.tahun }}</p>
                                <p><strong>Mapel:</strong> {{ form.mapel }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-green-600 text-white rounded">Whatsapp</button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Siplah</button>
                        <button class="px-4 py-2 bg-gray-800 text-white rounded">Cetak Kartu</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
