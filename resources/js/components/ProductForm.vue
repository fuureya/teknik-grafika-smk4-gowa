<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30" @click.self="close">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-full overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4">{{ form.id ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>

            <!-- Existing Images Preview -->
            <div v-if="props.product && props.product.id" class="mb-6 p-4 border rounded-lg bg-gray-50">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Gambar Saat Ini</h3>
                <div v-if="!props.product.cover_product && (!props.product.images || props.product.images.length === 0)" class="text-sm text-gray-500">
                    Tidak ada gambar untuk produk ini.
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                    <!-- Cover Image -->
                    <div v-if="props.product.cover_product" class="relative">
                        <img :src="`/storage/${props.product.cover_product}`" class="rounded-lg object-cover h-24 w-full">
                        <p class="text-center text-xs mt-1 font-semibold text-gray-600">Cover</p>
                    </div>
                    <!-- Other Images -->
                    <div v-for="image in props.product.images" :key="image.id" class="relative">
                        <img :src="`/storage/${image.image_path}`" class="rounded-lg object-cover h-24 w-full">
                        <button @click="deleteImage(image.id)" type="button" class="absolute -top-1 -right-1 p-1 bg-red-600 text-white rounded-full text-xs leading-none w-5 h-5 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Mengunggah gambar baru akan **menggantikan** gambar cover yang lama dan **menambahkan** gambar lainnya.</p>
            </div>

            <form @submit.prevent="submit">
                <!-- Nama Produk -->
                <div class="mb-4">
                    <label for="namaproduct" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="namaproduct" v-model="form.namaproduct" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.namaproduct" class="text-red-500 text-xs mt-1">{{ form.errors.namaproduct }}</div>
                </div>

                <!-- Harga -->
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="harga" v-model="form.harga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.harga" class="text-red-500 text-xs mt-1">{{ form.errors.harga }}</div>
                </div>

                <!-- Deskripsi Singkat -->
                <div class="mb-4">
                    <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                    <textarea id="deskripsi_singkat" v-model="form.deskripsi_singkat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    <div v-if="form.errors.deskripsi_singkat" class="text-red-500 text-xs mt-1">{{ form.errors.deskripsi_singkat }}</div>
                </div>

                <!-- Full Deskripsi -->
                <div class="mb-4">
                    <label for="full_deskripsi" class="block text-sm font-medium text-gray-700">Full Deskripsi</label>
                    <textarea id="full_deskripsi" v-model="form.full_deskripsi" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    <div v-if="form.errors.full_deskripsi" class="text-red-500 text-xs mt-1">{{ form.errors.full_deskripsi }}</div>
                </div>

                <!-- Cover Product -->
                <div class="mb-4">
                    <label for="cover_product" class="block text-sm font-medium text-gray-700">
                        {{ form.id ? 'Ganti Cover Produk' : 'Cover Produk' }}
                    </label>
                    <input type="file" @input="form.cover_product = $event.target.files[0]" id="cover_product" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    <div v-if="form.errors.cover_product" class="text-red-500 text-xs mt-1">{{ form.errors.cover_product }}</div>
                </div>

                <!-- Multiple Images -->
                <div class="mb-4">
                    <label for="images" class="block text-sm font-medium text-gray-700">
                        {{ form.id ? 'Tambah Gambar Lainnya' : 'Gambar Lainnya (Bisa lebih dari satu)' }}
                    </label>
                    <input type="file" @input="form.images = $event.target.files" id="images" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    <div v-if="form.errors.images" class="text-red-500 text-xs mt-1">{{ form.errors.images }}</div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4 mt-6">
                    <button type="button" @click="close" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none disabled:opacity-50">
                        <span v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        {{ form.id ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
    show: Boolean,
    product: Object,
});

const emit = defineEmits(['close']);

const form = useForm({
    _method: 'POST',
    id: null,
    namaproduct: '',
    harga: '',
    deskripsi_singkat: '',
    full_deskripsi: '',
    cover_product: null,
    images: [],
});

watch(() => props.product, (newProduct) => {
    if (newProduct) {
        form.id = newProduct.id;
        form.namaproduct = newProduct.namaproduct;
        form.harga = newProduct.harga;
        form.deskripsi_singkat = newProduct.deskripsi_singkat;
        form.full_deskripsi = newProduct.full_deskripsi;
        form.cover_product = null;
        form.images = [];
        form._method = 'PUT';
    } else {
        form.reset();
        form._method = 'POST';
    }
});

const submit = () => {
    if (form.id) {
        form.post('/admin/products/' + form.id, {
            onSuccess: () => close(),
        });
    } else {
        form.post('/admin/products', {
            onSuccess: () => close(),
        });
    }
};

const close = () => {
    emit('close');
};

const deleteImage = (imageId) => {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        router.delete('/admin/product-images/' + imageId, {
            preserveScroll: true,
            onSuccess: () => {
                // The page will be reloaded with the updated product data
            }
        });
    }
};
</script>
