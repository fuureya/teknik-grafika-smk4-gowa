<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30" @click.self="close">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-3xl max-h-full overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4">{{ form.id ? 'Edit Berita' : 'Tambah Berita Baru' }}</h2>
            
            <!-- Existing Cover Image Preview -->
            <div v-if="form.id && props.news.cover_berita" class="mb-4 p-4 border rounded-lg bg-gray-50">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Cover Berita Saat Ini</h3>
                <img :src="`/storage/${props.news.cover_berita}`" class="rounded-lg object-cover h-32 w-full">
                <p class="text-xs text-gray-500 mt-2">Mengunggah file baru akan menggantikan cover berita ini.</p>
            </div>

            <form @submit.prevent="submit">
                <!-- Judul -->
                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" id="judul" v-model="form.judul" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    <div v-if="form.errors.judul" class="text-red-500 text-xs mt-1">{{ form.errors.judul }}</div>
                </div>

                <!-- Cover Berita -->
                <div class="mb-4">
                    <label for="cover_berita" class="block text-sm font-medium text-gray-700">
                        {{ form.id && props.news.cover_berita ? 'Ganti Cover Berita' : 'Cover Berita' }}
                    </label>
                    <input type="file" @input="form.cover_berita = $event.target.files[0]" id="cover_berita" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    <div v-if="form.errors.cover_berita" class="text-red-500 text-xs mt-1">{{ form.errors.cover_berita }}</div>
                </div>

                <!-- Isi Berita (Summernote) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Berita</label>
                    <SummernoteEditor v-model="form.isi_berita" />
                    <div v-if="form.errors.isi_berita" class="text-red-500 text-xs mt-1">{{ form.errors.isi_berita }}</div>
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
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, watch } from 'vue';
import SummernoteEditor from '@/components/SummernoteEditor.vue';

const props = defineProps({
    show: Boolean,
    news: Object,
});

const emit = defineEmits(['close']);

const form = useForm({
    _method: 'POST',
    id: null,
    judul: '',
    isi_berita: '',
    cover_berita: null,
});

watch(() => props.news, (newNews) => {
    if (newNews) {
        form.id = newNews.id;
        form.judul = newNews.judul;
        form.isi_berita = newNews.isi_berita;
        form.cover_berita = null; // Reset file input
        form._method = 'PUT';
    } else {
        form.reset();
        form._method = 'POST';
    }
});

const submit = () => {
    if (form.id) {
        form.post('/admin/news/' + form.id, {
            onSuccess: () => close(),
        });
    } else {
        form.post('/admin/news', {
            onSuccess: () => close(),
        });
    }
};

const close = () => {
    emit('close');
};
</script>