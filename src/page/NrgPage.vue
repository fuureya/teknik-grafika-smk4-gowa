<script setup>
import { ref, nextTick } from "vue";
import cardBg from "@/assets/card.png"; // background depan
import cardBg2 from "@/assets/card2.png"; // background belakang
import html2canvas from "html2canvas"; // npm install html2canvas
import QRCode from "qrcode"; // npm install qrcode

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
const qrCodeUrl = ref(null);

const cardFrontRef = ref(null);
const cardBackRef = ref(null);

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
    qrCodeUrl.value = null;
};

// 📦 Generate QR code dari data form (selalu square)
const generateQRCode = async () => {
    const qrData = JSON.stringify(form.value, null, 2);
    qrCodeUrl.value = await QRCode.toDataURL(qrData, {
        width: 300,   // fix square 300x300
        margin: 2,
        scale: 10,    // kualitas tinggi, tetap square
    });
};

// 📸 Export card dengan ukuran fix 1011x638
const exportCard = async (refElement, filename) => {
    if (!refElement.value) return;

    const canvas = await html2canvas(refElement.value, {
        useCORS: true,
        backgroundColor: null,
        scale: 2, // ambil resolusi tinggi dulu
    });

    // Buat canvas baru dengan ukuran fix
    const fixedCanvas = document.createElement("canvas");
    fixedCanvas.width = 1011;
    fixedCanvas.height = 638;
    const ctx = fixedCanvas.getContext("2d");

    // Resize hasil ke ukuran fix
    ctx.drawImage(canvas, 0, 0, 1011, 638);

    const imgData = fixedCanvas.toDataURL("image/jpeg", 1.0);

    const link = document.createElement("a");
    link.href = imgData;
    link.download = filename;
    link.click();
};

const cetakDepan = () => {
    exportCard(cardFrontRef, `kartu_nrg_depan_${form.value.nama || "user"}.jpg`);
};

const cetakBelakang = async () => {
    await generateQRCode();
    await nextTick(); // tunggu QR code render
    exportCard(
        cardBackRef,
        `kartu_nrg_belakang_${form.value.nama || "user"}.jpg`
    );
};
</script>

<template>
    <main class="bg-gray-50 min-h-screen px-4 md:px-16 py-12">
        <!-- Form -->
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
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

                <!-- Depan -->
                <div ref="cardFrontRef"
                    class="relative border rounded-lg overflow-hidden w-full h-64 bg-cover bg-center"
                    :style="{ backgroundImage: `url(${cardBg})` }">
                    <div class="absolute inset-0 flex flex-col p-4 text-sm text-gray-900">
                        <div class="flex gap-4">
                            <div
                                class="w-24 h-28 bg-gray-200 flex items-center justify-center overflow-hidden rounded shadow">
                                <img v-if="photoUrl" :src="photoUrl" class="w-full h-full object-cover" />
                                <span v-else class="text-gray-400 text-xs">Foto</span>
                            </div>
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

                <!-- Belakang -->
                <div ref="cardBackRef"
                    class="relative border rounded-lg overflow-hidden w-full h-64 bg-cover bg-center flex items-center justify-center mt-6"
                    :style="{ backgroundImage: `url(${cardBg2})` }">
                    <!-- ✅ QR Code tetap square -->
                    <img v-if="qrCodeUrl" :src="qrCodeUrl" alt="QR Code"
                        class="w-28 h-28 bg-white p-1 rounded object-contain" />
                </div>

                <!-- Tombol Export -->
                <div class="flex gap-2 mt-6">
                    <button @click="cetakDepan" class="px-4 py-2 bg-green-600 text-white rounded">
                        Cetak Depan
                    </button>
                    <button @click="cetakBelakang" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Cetak Belakang
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>
