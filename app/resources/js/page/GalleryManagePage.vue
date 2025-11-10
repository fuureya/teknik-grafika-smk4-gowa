<template>
    <AuthenticatedLayout>
        <h1 class="text-2xl font-bold mb-6">Kelola Gallery</h1>

        <!-- Upload Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Unggah Gambar Baru</h2>
            <form @submit.prevent="form.post('/admin/gallery', { onSuccess: () => form.reset('images') })">
                <div class="mb-4">
                    <input type="file" @input="form.images = $event.target.files" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    <p class="text-xs text-gray-500 mt-1">Anda bisa memilih lebih dari satu gambar. Maksimal 1MB per gambar.</p>
                    <div v-if="form.errors.images" class="text-red-500 text-xs mt-1">{{ form.errors.images }}</div>
                </div>
                <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 disabled:opacity-50">
                    <span v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    Unggah
                </button>
            </form>
        </div>

        <!-- Image Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div v-if="images.length === 0" class="col-span-full">
                <p class="text-gray-500 text-center py-8">Galeri masih kosong.</p>
            </div>
            <div v-for="image in images" :key="image.id" class="relative group">
                <img :src="`/storage/${image.image_path}`" class="rounded-lg object-cover h-40 w-full cursor-pointer" @click="openImagePreview(image)">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-center justify-center">
                    <button @click.stop="confirmDelete(image.id)" class="text-white opacity-0 group-hover:opacity-100 transition-opacity text-4xl font-bold">
                        &times;
                    </button>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
        <div v-if="showImagePreview" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30" @click.self="showImagePreview = false">
            <div class="bg-white rounded-lg shadow-xl p-4 max-w-2xl max-h-full overflow-y-auto">
                <h3 class="text-xl font-bold mb-4">Pratinjau Gambar</h3>
                <img :src="`/storage/${viewingImage.image_path}`" class="w-full h-auto rounded-lg object-contain">
                <p v-if="viewingImage.caption" class="text-center text-gray-700 mt-2">{{ viewingImage.caption }}</p>
                <button @click="showImagePreview = false" class="mt-4 px-4 py-2 bg-gray-200 rounded-lg">Tutup</button>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    images: Array,
});

const form = useForm({
    images: [],
});

const showImagePreview = ref(false);
const viewingImage = ref(null);

const openImagePreview = (image) => {
    viewingImage.value = image;
    showImagePreview.value = true;
};

const confirmDelete = (imageId) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan bisa mengembalikan gambar ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/admin/gallery/${imageId}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire('Dihapus!','Gambar telah dihapus.','success')
                }
            });
        }
    })
};
</script>