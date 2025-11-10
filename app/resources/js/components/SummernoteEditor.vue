<template>
    <div ref="editor"></div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, defineProps, defineEmits } from 'vue';
import $ from 'jquery';
import 'summernote/dist/summernote-lite.min.js';
import 'summernote/dist/summernote-lite.min.css';
import axios from 'axios';

const props = defineProps({
    modelValue: String,
});

const emit = defineEmits(['update:modelValue']);

const editor = ref(null);

onMounted(() => {
    $(editor.value).summernote({
        height: 250,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            // Removed ['insert', ['picture']]
            ['view', ['fullscreen', 'help']]
        ],
        callbacks: {
            onChange: function(contents) {
                emit('update:modelValue', contents);
            },
            onImageUpload: function(files) {
                const formData = new FormData();
                formData.append('image', files[0]);

                axios.post('/admin/news/upload-image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }).then(response => {
                    $(editor.value).summernote('insertImage', response.data.url);
                }).catch(error => {
                    console.error('Image upload failed:', error);
                    alert('Image upload failed. Please check the console for details.');
                });
            }
        }
    });
    // Set initial content
    $(editor.value).summernote('code', props.modelValue);
});

watch(() => props.modelValue, (newValue) => {
    // Update summernote content if modelValue changes from outside
    if ($(editor.value).summernote('code') !== newValue) {
        $(editor.value).summernote('code', newValue);
    }
});

onUnmounted(() => {
    if ($(editor.value).hasClass('note-editor')) {
        $(editor.value).summernote('destroy');
    }
});
</script>

<style>
/* Scoped styles can be tricky with dynamically generated content like Summernote's dropdowns. */
/* We'll use a global style block here, but be mindful of potential conflicts. */
.note-editor.note-frame {
    border-radius: 0.375rem;
    border-color: #d1d5db;
}
.note-toolbar {
    background-color: #f9fafb;
    border-bottom: 1px solid #d1d5db;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
}

/* Fix Summernote dialog z-index issue inside modals */
.note-dialog {
    z-index: 9999 !important; /* A very high z-index */
}
.note-modal-backdrop {
    z-index: 9998 !important; /* Ensure backdrop is also high, but below dialog */
}
</style>