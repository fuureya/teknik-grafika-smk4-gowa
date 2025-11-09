<template>
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Kelola User</h1>
            <button @click="openFormModal()" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                + Tambah User Baru
            </button>
        </div>

        <div class="mb-4">
            <input type="text" v-model="search" placeholder="Cari user..." class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-if="users.data.length === 0">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada user yang ditemukan.
                        </td>
                    </tr>
                    <tr v-for="(user, index) in users.data" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ users.from + index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="user.foto_profile" :src="`/storage/${user.foto_profile}`" class="h-10 w-10 rounded-full object-cover">
                            <span v-else class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                {{ user.namalengkap.charAt(0) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ user.namalengkap }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ user.username }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="user.role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'"
                                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                {{ user.role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button @click="openFormModal(user)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</button>
                            <button @click="confirmDelete(user.id)" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <Pagination :links="users.links" />
        </div>

        <UserForm :show="showForm" :user="editingUser" @close="showForm = false" />

    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserForm from '@/components/UserForm.vue';
import Pagination from '@/components/Pagination.vue';
import debounce from 'lodash/debounce';
import Swal from 'sweetalert2';

const props = defineProps({
    users: Object,
    filters: Object,
});

const search = ref(props.filters.search);
const showForm = ref(false);
const editingUser = ref(null);

watch(search, debounce((value) => {
    router.get('/admin/users', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const openFormModal = (user = null) => {
    editingUser.value = user;
    showForm.value = true;
};

const confirmDelete = (userId) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan bisa mengembalikan data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete('/admin/users/' + userId, {
                onSuccess: () => {
                    Swal.fire('Dihapus!','User telah dihapus.','success')
                }
            });
        }
    })
};
</script>
