<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30" @click.self="close">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg max-h-full overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4">{{ form.id ? 'Edit User' : 'Tambah User Baru' }}</h2>
            <form @submit.prevent="submit">
                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="namalengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" v-model="form.namalengkap" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    <div v-if="form.errors.namalengkap" class="text-red-500 text-xs mt-1">{{ form.errors.namalengkap }}</div>
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" v-model="form.username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    <div v-if="form.errors.username" class="text-red-500 text-xs mt-1">{{ form.errors.username }}</div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" v-model="form.password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    <p v-if="form.id" class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                    <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select v-model="form.role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="admin">Admin</option>
                        <option value="siswa">Siswa</option>
                    </select>
                    <div v-if="form.errors.role" class="text-red-500 text-xs mt-1">{{ form.errors.role }}</div>
                </div>

                <!-- Foto Profile -->
                <div class="mb-4">
                    <label for="foto_profile" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                    <input type="file" @input="form.foto_profile = $event.target.files[0]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    <div v-if="form.errors.foto_profile" class="text-red-500 text-xs mt-1">{{ form.errors.foto_profile }}</div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4 mt-6">
                    <button type="button" @click="close" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Batal</button>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 disabled:opacity-50">
                        <span v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white">
                            <!-- Spinner -->
                        </span>
                        {{ form.id ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
    show: Boolean,
    user: Object,
});

const emit = defineEmits(['close']);

const form = useForm({
    _method: 'POST',
    id: null,
    namalengkap: '',
    username: '',
    password: '',
    role: 'siswa',
    foto_profile: null,
});

watch(() => props.user, (newUser) => {
    if (newUser) {
        form.id = newUser.id;
        form.namalengkap = newUser.namalengkap;
        form.username = newUser.username;
        form.role = newUser.role;
        form.password = ''; // Always clear password on edit
        form.foto_profile = null;
        form._method = 'PUT';
    } else {
        form.reset();
        form._method = 'POST';
    }
});

const submit = () => {
    if (form.id) {
        form.post('/admin/users/' + form.id, {
            onSuccess: () => close(),
        });
    } else {
        form.post('/admin/users', {
            onSuccess: () => close(),
        });
    }
};

const close = () => {
    emit('close');
};
</script>
