<template>

    <Head title="Sign In" />

    <div class="min-h-screen h-screen flex font-sans overflow-hidden flex-col md:flex-row">
        <!-- Form Section -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-light min-h-screen">
            <div class="w-full max-w-md px-4 py-8 rounded-lg md:ml-20 lg:ml-56">
                <img src="/images/flaglogo.png" alt="Logo" class="w-20 md:w-24 mx-auto mb-6" />
                <h1 class="text-2xl md:text-3xl font-bold text-center mb-4">Sign In</h1>
                <h2 class="text-lg md:text-xl text-center mb-4">
                    Welcome back! Please sign in to continue.
                </h2>

                <form @submit.prevent="submit">
                    <!-- Username/Email -->
                    <div class="mb-4">
                        <label for="login" class="block text-sm font-medium text-gray-700 mb-1">
                            Username or Email
                        </label>
                        <input id="login" v-model="form.login" type="text" required autocomplete="username"
                            class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30" />
                    </div>

                    <!-- Password with eye toggle -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative flex items-center">
                            <input :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password"
                                required autocomplete="current-password"
                                class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30 pr-10" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-2 text-gray-400 hover:text-primary focus:outline-none flex items-center justify-center"
                                tabindex="-1" aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined select-none leading-none">
                                    {{ showPassword ? 'visibility_off' : 'visibility' }}
                                </span>
                            </button>
                        </div>
                    </div>


                    <!-- Remember Me -->
                    <div class="flex items-center mb-6">
                        <input id="remember" type="checkbox" v-model="form.remember"
                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" />
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-md bg-primary text-secondary font-semibold hover:bg-secondary hover:text-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="form.processing">
                        Sign In
                    </button>

                    <!-- Forgot Password -->
                    <p class="text-sm text-center mt-4">
                        <Link href="/forgot-password" class="underline text-primary hover:text-secondary">
                            Forgot your password?
                        </Link>
                    </p>
                    <p class="text-sm text-center mt-4">
                        <Link href="/signup" class="underline text-primary hover:text-secondary">
                            Don't have an account? Sign Up
                        </Link>
                    </p>
                </form>
            </div>
        </div>

        <!-- Illustration Section -->
        <div class="hidden md:flex items-center justify-center bg-light w-1/2 min-h-screen">
            <div class="text-gray-400 text-lg">
                <img src="/images/illustration/auth2.svg" alt="Illustration"
                    class="w-72 md:w-96 mr-0 md:mr-10 h-auto" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    login: '', // username or email
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
