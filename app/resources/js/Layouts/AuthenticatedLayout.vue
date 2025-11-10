<template>
    <div class="flex min-h-screen bg-gray-100">
        <Sidebar :is-open="isSidebarOpen" @toggle="toggleSidebar" />
        <div :class="{'ml-64': isSidebarOpen, 'ml-16': !isSidebarOpen}"
             class="flex-1 transition-all duration-300 ease-in-out p-4">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Sidebar from '@/components/Sidebar.vue';

const isSidebarOpen = ref(true);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>
