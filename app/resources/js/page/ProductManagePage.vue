<template>
    <AuthenticatedLayout>
        <!-- Main Content -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Kelola Product</h1>
            <button @click="openFormModal()" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah Produk Baru
            </button>
        </div>

        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" v-model="search" placeholder="Cari produk..." class="w-full px-4 py-2 border rounded-lg">
        </div>

        <!-- Products Table -->
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi Singkat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-if="products.data.length === 0">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada produk yang ditemukan.
                        </td>
                    </tr>
                    <tr v-for="(product, index) in products.data" :key="product.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ products.from + index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="product.cover_product" :src="`/storage/${product.cover_product}`" alt="Cover" 
                                 class="h-10 w-10 rounded-md object-cover cursor-pointer" @click="openImagePreview(product)">
                            <span v-else class="text-gray-400">No Cover</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ product.namaproduct }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">Rp {{ new Intl.NumberFormat('id-ID').format(product.harga) }}</td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">{{ product.deskripsi_singkat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button @click="openFormModal(product)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                            <button @click="confirmDelete(product.id)" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <Pagination :links="products.links" />
        </div>

        <!-- Form Modal -->
        <ProductForm :show="showForm" :product="editingProduct" @close="showForm = false" />

        <!-- Image Preview Modal -->
        <div v-if="showImagePreview" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30" @click.self="showImagePreview = false">
            <div class="bg-white rounded-lg shadow-xl p-4 w-full max-w-4xl">
                <h3 class="text-xl font-bold mb-4">Pratinjau Gambar: {{ viewingProduct.namaproduct }}</h3>
                <div v-if="allImages.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div v-for="(image, index) in allImages" :key="index">
                        <img :src="`/storage/${image.path}`" class="w-full h-auto rounded-lg object-cover">
                        <p class="text-center text-xs mt-1">{{ image.type }}</p>
                    </div>
                </div>
                <p v-else class="text-gray-500">Tidak ada gambar untuk produk ini.</p>
                <button @click="showImagePreview = false" class="mt-4 px-4 py-2 bg-gray-200 rounded-lg">Tutup</button>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductForm from '@/components/ProductForm.vue';
import Pagination from '@/components/Pagination.vue';
import { Link } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import Swal from 'sweetalert2';

const props = defineProps({
    products: Object,
    filters: Object,
});

const search = ref(props.filters.search);
const showForm = ref(false);
const editingProduct = ref(null);
const showImagePreview = ref(false);
const viewingProduct = ref(null);

const allImages = computed(() => {
    if (!viewingProduct.value) return [];
    const images = [];
    if (viewingProduct.value.cover_product) {
        images.push({ path: viewingProduct.value.cover_product, type: 'Cover' });
    }
    if (viewingProduct.value.images) {
        viewingProduct.value.images.forEach(img => {
            images.push({ path: img.image_path, type: 'Gambar Lain' });
        });
    }
    return images;
});

watch(search, debounce((value) => {
    router.get('/admin/products', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const openFormModal = (product = null) => {
    editingProduct.value = product;
    showForm.value = true;
};

const openImagePreview = (product) => {
    viewingProduct.value = product;
    showImagePreview.value = true;
};

const confirmDelete = (productId) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan bisa mengembalikan data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete('/admin/products/' + productId, {
                onSuccess: () => {
                    Swal.fire(
                        'Dihapus!',
                        'Produk telah dihapus.',
                        'success'
                    )
                }
            });
        }
    })
};
</script>
