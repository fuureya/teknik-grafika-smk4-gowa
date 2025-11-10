<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const isMounted = ref(false);
onMounted(() => {
    isMounted.value = true;
});
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Decorative Panel (Left Side) -->
        <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-700 to-blue-900 items-center justify-center p-12 text-white text-center">
            <div>
                <h1 class="text-5xl font-extrabold">Selamat Datang Kembali</h1>
                <p class="mt-4 text-lg opacity-80">Masuk untuk mengakses dasbor dan mengelola konten Anda.</p>
            </div>
        </div>

        <!-- Login Form (Right Side) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <transition
                enter-active-class="transition-opacity duration-1000 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
            >
                <div v-if="isMounted" class="w-full max-w-md">
                    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl">
                        <h3 class="text-3xl font-bold text-center text-gray-800">Login ke Akun Anda</h3>
                        <form @submit.prevent="form.post('/login')" class="mt-8 space-y-6">
                            <div>
                                <label for="username" class="text-sm font-bold text-gray-600 block">Username</label>
                                <input 
                                    id="username"
                                    type="text" 
                                    placeholder="Masukkan username Anda"
                                    class="w-full px-4 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    v-model="form.username"
                                    required
                                >
                                <div v-if="form.errors.username" class="text-red-500 text-xs mt-1">{{ form.errors.username }}</div>
                            </div>
                            <div>
                                <label for="password" class="text-sm font-bold text-gray-600 block">Password</label>
                                <input 
                                    id="password"
                                    type="password" 
                                    placeholder="Masukkan password Anda"
                                    class="w-full px-4 py-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    v-model="form.password"
                                    required
                                >
                                <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                            </div>
                            <div>
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="w-full px-6 py-3 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 transition-colors"
                                >
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>
