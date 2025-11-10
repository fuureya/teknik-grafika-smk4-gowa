<script setup>
import { ref, nextTick, computed, watchEffect } from "vue";
import cardBg from "@/assets/card.png";
import cardBg2 from "@/assets/card2.png";
import html2canvas from "html2canvas";
import QRCode from "qrcode";

const form = ref({
    nrg: "",
    nama: "",
    peserta: "",
    sertifikat: "",
    tahun: "",
    mapel: "",
    photo: null,
});

const errors = ref({});
const photoUrl = ref(null);
const qrCodeUrl = ref(null);
const isLoading = ref(false); // Loading state

const cardFrontRef = ref(null);
const cardBackRef = ref(null);

// Upload foto validasi
const handlePhotoUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        const validTypes = ["image/jpeg", "image/png"];
        if (!validTypes.includes(file.type)) {
            errors.value.photo = "Foto harus JPG atau PNG";
            form.value.photo = null;
            photoUrl.value = null;
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            errors.value.photo = "Ukuran foto maksimal 2MB";
            form.value.photo = null;
            photoUrl.value = null;
            return;
        }
        form.value.photo = file;
        photoUrl.value = URL.createObjectURL(file);
        errors.value.photo = null;
    }
};

const resetForm = () => {
    form.value = { nrg: "", nama: "", peserta: "", sertifikat: "", tahun: "", mapel: "", photo: null };
    photoUrl.value = null;
    qrCodeUrl.value = null;
    errors.value = {};
};

// Validasi
const validateForm = () => {
    const e = {};
    if (!/^\d{1,16}$/.test(form.value.nrg)) e.nrg = "NRG harus angka max 16 digit";
    if (!form.value.nama || form.value.nama.length > 40) e.nama = "Nama max 40 karakter";
    if (!form.value.peserta || form.value.peserta.length > 20) e.peserta = "Nomor Peserta max 20 karakter";
    if (!form.value.sertifikat || form.value.sertifikat.length > 50) e.sertifikat = "Nomor Sertifikat max 50 karakter";
    if (!/^\d{1,4}$/.test(form.value.tahun)) e.tahun = "Tahun harus angka max 4 digit";
    if (!form.value.mapel || form.value.mapel.length > 50) e.mapel = "Mapel max 50 karakter";
    if (!form.value.photo) e.photo = "Foto wajib diupload";
    errors.value = e;
    return Object.keys(e).length === 0;
};

const isFormValid = computed(() => validateForm());

// Auto-generate QR Code when form is valid
watchEffect(async () => {
    if (isFormValid.value) {
        const qrData = JSON.stringify({
            nrg: form.value.nrg,
            nama: form.value.nama,
            peserta: form.value.peserta,
            sertifikat: form.value.sertifikat,
            tahun: form.value.tahun,
            mapel: form.value.mapel,
        }, null, 2);
        qrCodeUrl.value = await QRCode.toDataURL(qrData, { width: 300, margin: 2, scale: 10 });
    } else {
        qrCodeUrl.value = null;
    }
});


// Export kartu
const exportCard = async (refElement, filename) => {
    if (!refElement.value) return;
    const canvas = await html2canvas(refElement.value, { useCORS: true, backgroundColor: null, scale: 2 });

    const fixedCanvas = document.createElement("canvas");
    fixedCanvas.width = 1011;
    fixedCanvas.height = 638;
    const ctx = fixedCanvas.getContext("2d");
    ctx.drawImage(canvas, 0, 0, 1011, 638);

    const imgData = fixedCanvas.toDataURL("image/jpeg", 1.0);
    const link = document.createElement("a");
    link.href = imgData;
    link.download = filename;
    link.click();
};

const cetakDepan = async () => {
    if (!isFormValid.value) return;
    isLoading.value = true;
    try {
        await exportCard(cardFrontRef, `kartu_nrg_depan_${form.value.nama || "user"}.jpg`);
    } finally {
        isLoading.value = false;
    }
};

const cetakBelakang = async () => {
    if (!isFormValid.value) return;
    isLoading.value = true;
    try {
        // QR code is already generated, just wait for it to be loaded before printing
        await new Promise(resolve => {
            if (!qrCodeUrl.value) { // Should not happen if form is valid, but as a safeguard
                resolve();
                return;
            }
            const img = new Image();
            img.onload = resolve;
            img.onerror = resolve;
            img.src = qrCodeUrl.value;
        });

        await exportCard(cardBackRef, `kartu_nrg_belakang_${form.value.nama || "user"}.jpg`);
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <main class="bg-gray-50 min-h-screen px-4 md:px-16 py-12">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 transition hover:shadow-xl">
                <h2
                    class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-6 text-lg font-semibold">
                    Form Isian
                </h2>
                <div class="space-y-4">
                    <div>
                        <input v-model="form.nrg" type="text" placeholder="NRG (16 Digit)"
                            class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" />
                        <p v-if="errors.nrg" class="text-xs text-red-500">{{ errors.nrg }}</p>
                    </div>
                    <div>
                        <input v-model="form.nama" type="text" placeholder="Nama Lengkap"
                            class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" />
                        <p v-if="errors.nama" class="text-xs text-red-500">{{ errors.nama }}</p>
                    </div>
                    <div>
                        <input v-model="form.peserta" type="text" placeholder="Nomor Peserta"
                            class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" />
                        <p v-if="errors.peserta" class="text-xs text-red-500">{{ errors.peserta }}</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <input v-model="form.sertifikat" type="text" placeholder="Nomor Sertifikat"
                                class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" />
                            <p v-if="errors.sertifikat" class="text-xs text-red-500">{{ errors.sertifikat }}</p>
                        </div>
                        <div>
                            <input v-model="form.tahun" type="text" placeholder="Tahun"
                                class="w-24 border rounded p-2 focus:ring-2 focus:ring-blue-500" />
                            <p v-if="errors.tahun" class="text-xs text-red-500">{{ errors.tahun }}</p>
                        </div>
                    </div>
                    <div>
                        <input v-model="form.mapel" type="text" placeholder="Mapel / Bidang Tugas"
                            class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500" />
                        <p v-if="errors.mapel" class="text-xs text-red-500">{{ errors.mapel }}</p>
                    </div>
                    <div>
                        <input type="file" @change="handlePhotoUpload" accept="image/*" class="w-full" />
                        <p class="text-xs text-gray-500">File Pas Photo | 2x3 | Format (.jpg/.jpeg/.png) | Max 2MB</p>
                        <p v-if="errors.photo" class="text-xs text-red-500">{{ errors.photo }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button @click="resetForm" :disabled="isLoading"
                        class="px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-700 text-white rounded shadow hover:scale-105 transition disabled:opacity-50 disabled:cursor-wait">Reset</button>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white rounded-xl shadow-lg p-6 transition hover:shadow-xl">
                <h2
                    class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-2 rounded-t-lg -mx-6 -mt-6 mb-6 text-lg font-semibold">
                    Live Preview Kartu NRG
                </h2>

                <!-- Depan -->
                <div ref="cardFrontRef"
                    class="relative border rounded-lg overflow-hidden w-full h-64 bg-cover bg-center transform transition hover:rotate-1 hover:scale-[1.02]"
                    :style="{ backgroundImage: `url(${cardBg})` }">
                    <div class="absolute inset-0 flex flex-col p-4 text-sm text-gray-900">
                        <div class="flex gap-4">
                            <div
                                class="w-24 h-28 bg-gray-200 flex items-center justify-center overflow-hidden rounded shadow group">
                                <img v-if="photoUrl" :src="photoUrl"
                                    class="w-full h-full object-cover transition transform group-hover:scale-110" />
                                <span v-else class="text-gray-400 text-xs">Foto</span>
                            </div>
                            <div class="text-sm space-y-1 animate-fadeIn">
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

                <!-- Belakang -->
                <div ref="cardBackRef"
                    class="relative border rounded-lg overflow-hidden w-full h-64 bg-cover bg-center flex items-center justify-center mt-6 transform transition hover:-rotate-1 hover:scale-[1.02]"
                    :style="{ backgroundImage: `url(${cardBg2})` }">
                    <transition name="fade">
                        <img v-if="qrCodeUrl" :src="qrCodeUrl" alt="QR Code"
                            class="w-28 h-28 bg-white p-1 rounded object-contain shadow-lg" />
                    </transition>
                </div>

                <!-- Tombol Export -->
                <div class="flex gap-2 mt-6">
                    <button @click="cetakDepan" :disabled="!isFormValid || isLoading"
                        class="px-4 py-2 rounded text-white font-semibold transition transform active:scale-95 disabled:cursor-not-allowed disabled:opacity-50 w-36 text-center"
                        :class="isFormValid ? 'bg-gradient-to-r from-green-500 to-green-700 hover:shadow-lg' : 'bg-gray-400'">
                        <span v-if="isLoading">Mencetak...</span>
                        <span v-else>Cetak Depan</span>
                    </button>
                    <button @click="cetakBelakang" :disabled="!isFormValid || isLoading"
                        class="px-4 py-2 rounded text-white font-semibold transition transform active:scale-95 disabled:cursor-not-allowed disabled:opacity-50 w-36 text-center"
                        :class="isFormValid ? 'bg-gradient-to-r from-blue-500 to-blue-700 hover:shadow-lg' : 'bg-gray-400'">
                        <span v-if="isLoading">Mencetak...</span>
                        <span v-else>Cetak Belakang</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
