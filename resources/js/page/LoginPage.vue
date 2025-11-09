<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-lg">
            <h3 class="text-2xl font-bold text-center">Login ke Akun Anda</h3>
            <form @submit.prevent="form.post('/login')">
                <div class="mt-4">
                    <div>
                        <label class="block" for="username">Username</label>
                        <input type="text" placeholder="Username"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                            v-model="form.username">
                        <div v-if="form.errors.username" class="text-red-500 text-xs mt-1">{{ form.errors.username }}</div>
                    </div>
                    <div class="mt-4">
                        <label class="block" for="password">Password</label>
                        <input type="password" placeholder="Password"
                            class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                            v-model="form.password">
                        <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <button type="submit" :disabled="form.processing"
                            class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900"
                        >
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    username: '',
    password: '',
    remember: false,
});
</script>

<style scoped>
/* Add any specific styles for the login page here */
</style>
