<template>

    <Head title="Forgot Password" />

    <div class="min-h-screen h-screen flex font-sans overflow-hidden flex-col md:flex-row">
        <!-- Form Section -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-light min-h-screen">
            <div class="w-full max-w-md px-4 py-8 rounded-lg md:ml-20 lg:ml-56">
                <img src="/images/flaglogo.png" alt="Logo" class="w-20 md:w-24 mx-auto mb-6" />
                <h1 class="text-2xl md:text-3xl font-bold text-center mb-4">Forgot Password</h1>
                <h2 class="text-lg md:text-xl text-center mb-4">
                    No problem. Enter your email address and we’ll send you a reset link.
                </h2>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input id="email" v-model="form.email" type="email" required autocomplete="username" autofocus
                            class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30" />
                        <p v-if="form.errors.email" class="text-sm text-red-500 mt-1">{{ form.errors.email }}</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-md bg-primary text-secondary font-semibold hover:bg-secondary hover:text-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="form.processing">
                        Email Password Reset Link
                    </button>

                    <!-- Back to Sign In -->
                    <p class="text-sm text-center mt-4">
                        <Link href="/signin" class="underline text-primary hover:text-secondary">
                            Back to Sign In
                        </Link>
                    </p>
                </form>
            </div>
        </div>

        <!-- Illustration Section -->
        <div class="hidden md:flex items-center justify-center bg-light w-1/2 min-h-screen">
            <div class="text-gray-400 text-lg">
                <img src="/images/illustration/auth3.svg" alt="Illustration"
                    class="w-72 md:w-96 mr-0 md:mr-10 h-auto" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
