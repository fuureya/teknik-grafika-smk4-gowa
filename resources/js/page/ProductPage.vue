<script setup>
import Navbar from '@/components/Navbar.vue';
import Jumbotron from '@/components/Jumbotron.vue';
import Footer from '@/components/Footer.vue';
import Pagination from '@/components/Pagination.vue';
import { ref, computed, onMounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import throttle from 'lodash/throttle';

const props = defineProps({
    products: Object,
    filters: Object,
});

const visibleProducts = ref([]);
const search = ref(props.filters.search);

onMounted(() => {
    if (props.products && props.products.data) {
        visibleProducts.value = Array(props.products.data.length).fill(false);
    }
});

watch(search, throttle(function (value) {
    router.get('/produk', { search: value }, {
        replace: true,
    });
}, 300));


// Modal state
const isModalOpen = ref(false);
const selectedProduct = ref(null);
const activeImageIndex = ref(0);

const openModal = (product) => {
    selectedProduct.value = product;
    activeImageIndex.value = 0; // Reset to cover image on open
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    selectedProduct.value = null;
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
};

const whatsappLink = computed(() => {
    if (selectedProduct.value) {
        const phoneNumber = '6281234567890'; // Placeholder
        const message = `Saya tertarik dengan produk '${selectedProduct.value.namaproduct}'.`;
        return `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    }
    return '#';
});

const modalImages = computed(() => {
    if (selectedProduct.value) {
        return [
            { image_path: selectedProduct.value.cover_product },
            ...selectedProduct.value.images
        ];
    }
    return [];
});

</script>

<template>
    <Navbar />
    <Jumbotron />

    <div class="min-h-screen bg-white px-6 py-16">
        <h1 class="text-4xl font-bold text-blue-800 text-center mb-6">Produk Terbaru</h1>

        <!-- Search Input -->
        <div class="max-w-md mx-auto mb-12">
            <input type="text" v-model="search" placeholder="Cari produk..." class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-for="(product, index) in products.data" :key="product.id"
                class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-700 opacity-0 hover:scale-105 hover:shadow-2xl cursor-pointer flex flex-col"
                v-intersect.once="visibleProducts[index] = true"
                :class="{ 'opacity-100 translate-y-0': visibleProducts[index] }"
                @click="openModal(product)">
                <img :src="`/storage/${product.cover_product}`" alt="Product Image" class="w-full h-48 object-cover">
                <div class="p-6 bg-gradient-to-br from-blue-400 to-blue-700 text-white flex-grow flex flex-col">
                    <h2 class="text-xl font-bold mb-1">{{ product.namaproduct }}</h2>
                    <p class="text-white/80 text-sm mb-2">{{ formatCurrency(product.harga) }}</p>
                    <p class="text-white/90 text-base flex-grow">{{ product.deskripsi_singkat }}</p>
                </div>
            </div>
        </div>

        <div v-if="products.data.length === 0" class="text-center text-gray-500 mt-8">
            Tidak ada produk yang ditemukan.
        </div>

        <div class="mt-8 flex justify-center">
            <Pagination :links="products.links" />
        </div>
    </div>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" @click.self="closeModal">
        <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white p-4 border-b flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">{{ selectedProduct.namaproduct }}</h3>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-800 text-3xl">&times;</button>
            </div>
            
            <div class="p-6">
                <!-- Image Gallery -->
                <div class="mb-4">
                    <img :src="`/storage/${modalImages[activeImageIndex].image_path}`" class="w-full h-64 object-cover rounded-lg shadow-md mb-2">
                    <div v-if="modalImages.length > 1" class="flex space-x-2 justify-center">
                        <img v-for="(image, index) in modalImages" :key="index" :src="`/storage/${image.image_path}`" 
                             class="w-16 h-16 object-cover rounded-md cursor-pointer border-2"
                             :class="{'border-blue-500': activeImageIndex === index}"
                             @click="activeImageIndex = index">
                    </div>
                </div>

                <p class="text-2xl font-bold text-blue-700 mb-4">{{ formatCurrency(selectedProduct.harga) }}</p>
                <div class="prose max-w-none" v-html="selectedProduct.full_deskripsi"></div>
            </div>

            <div class="sticky bottom-0 bg-gray-100 p-4 border-t">
                <a :href="whatsappLink" target="_blank" class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700">
                    Pesan Sekarang via WhatsApp
                </a>
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
