<template>
    <AuthenticatedLayout>
        <!-- Main Content -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Kelola Berita</h1>
            <button @click="openFormModal()" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah Berita Baru
            </button>
        </div>

        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" v-model="search" placeholder="Cari berita..." class="w-full px-4 py-2 border rounded-lg">
        </div>

        <!-- News Table -->
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Oleh</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-if="news.data.length === 0">
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada berita yang ditemukan.
                        </td>
                    </tr>
                    <tr v-for="(item, index) in news.data" :key="item.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ news.from + index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="item.cover_berita" :src="`/storage/${item.cover_berita}`" alt="Cover" class="h-10 w-16 rounded-md object-cover">
                            <span v-else class="text-gray-400">No Cover</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ item.judul }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ item.created_by.namalengkap }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button @click="openFormModal(item)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                            <button @click="confirmDelete(item.id)" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <Pagination :links="news.links" />
        </div>

        <!-- Form Modal -->
        <NewsForm :show="showForm" :news="editingNews" @close="showForm = false" />

    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NewsForm from '@/components/NewsForm.vue';
import Pagination from '@/components/Pagination.vue';
import debounce from 'lodash/debounce';
import Swal from 'sweetalert2';

const props = defineProps({
    news: Object,
    filters: Object,
});

const search = ref(props.filters.search);
const showForm = ref(false);
const editingNews = ref(null);

watch(search, debounce((value) => {
    router.get('/admin/news', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const openFormModal = (newsItem = null) => {
    editingNews.value = newsItem;
    showForm.value = true;
};

const confirmDelete = (newsId) => {
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
            router.delete('/admin/news/' + newsId, {
                onSuccess: () => {
                    Swal.fire('Dihapus!','Berita telah dihapus.','success')
                }
            });
        }
    })
};
</script>
