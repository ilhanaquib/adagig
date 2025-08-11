<template>

    <!-- TODO: Center eye icon -->

    <Head title="Sign Up" />

    <div class="min-h-screen h-screen flex font-sans overflow-hidden flex-col md:flex-row">
        <!-- Form Section -->
        <div class="
                w-full
                md:w-1/2
                flex items-center justify-center bg-light
                min-h-screen
            ">
            <div class="
                    w-full
                    max-w-md
                    px-4
                    py-8
                    rounded-lg
                    md:ml-20
                    lg:ml-56
                ">
                <img src="/images/flaglogo.png" alt="Logo" class="w-20 md:w-24 mx-auto mb-6" />
                <h1 class="text-2xl md:text-3xl font-bold text-center mb-4">Sign Up</h1>
                <h2 class="text-lg md:text-xl text-center mb-4">
                    Welcome! Can't wait for you to join our community
                </h2>
                <form @submit.prevent="submit">
                    <div class="flex flex-col md:flex-row gap-4 mb-4">
                        <div class="w-full md:w-1/2">
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First
                                Name</label>
                            <input id="first_name" v-model="form.first_name" type="text" required
                                autocomplete="given-name"
                                class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30" />
                        </div>
                        
                        <div class="w-full md:w-1/2 relative group">
                            <label for="last_name"
                                class="block text-sm font-medium text-gray-700 mb-1 flex items-center justify-between">
                                <span>Last Name</span>
                                <span class="relative">
                                    <span
                                        class="inline-block w-4 h-4 rounded-full bg-primary text-secondary text-xs font-bold flex items-center justify-center cursor-pointer ml-1"
                                        tabindex="0">i</span>
                                    <span
                                        class="absolute right-0 mt-1 w-40 bg-white text-gray-700 text-xs rounded shadow-lg px-2 py-1 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity z-10 pointer-events-none">
                                        Your first and last name will be used as your display name.
                                    </span>
                                </span>
                            </label>
                            <input id="last_name" v-model="form.last_name" type="text" required
                                autocomplete="family-name"
                                class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30" />
                        </div>
                    </div>

                    <div class="mb-4 relative group">
                        <label for="username"
                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center justify-between">
                            <span>Username</span>
                            <span class="relative">
                                <span
                                    class="inline-block w-4 h-4 rounded-full bg-primary text-secondary text-xs font-bold flex items-center justify-center cursor-pointer ml-1"
                                    tabindex="0">i</span>
                                <span
                                    class="absolute right-0 mt-1 w-48 bg-white text-gray-700 text-xs rounded shadow-lg px-2 py-1 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity z-10 pointer-events-none">
                                    Your username will be your unique identifier (your '@').
                                </span>
                            </span>
                        </label>
                        <input id="username" v-model="form.username" type="text" required autocomplete="username"
                            class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30" />
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" v-model="form.email" type="email" required autocomplete="email"
                            class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30" />
                    </div>

                    <div class="mb-4 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password" required
                            autocomplete="new-password"
                            class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30 pr-10" />
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary focus:outline-none"
                            tabindex="-1" aria-label="Toggle password visibility">
                            <span class="material-symbols-outlined select-none">
                                {{ showPassword ? 'visibility_off' : 'visibility' }}
                            </span>
                        </button>
                        <p class="text-xs text-gray-500 mt-1">
                            Must be at least 8 characters, include 1 uppercase letter, 1 number, and 1 special
                            character.
                        </p>
                    </div>

                    <div class="mb-4 relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                            Password</label>
                        <input :type="showPasswordConfirmation ? 'text' : 'password'" id="password_confirmation"
                            v-model="form.password_confirmation" required autocomplete="new-password"
                            class="block w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary/30 pr-10" />
                        <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary focus:outline-none"
                            tabindex="-1" aria-label="Toggle confirm password visibility">
                            <span class="material-symbols-outlined select-none">
                                {{ showPasswordConfirmation ? 'visibility_off' : 'visibility' }}
                            </span>
                        </button>
                    </div>

                    <div class="flex items-center mb-6">
                        <input id="terms" type="checkbox" v-model="form.terms" required
                            class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" />
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the
                            <a href="/terms" target="_blank" class="underline text-primary hover:text-secondary">Terms
                                and Conditions</a>
                            and
                            <a href="/privacy" target="_blank"
                                class="underline text-primary hover:text-secondary">Privacy Policy</a>
                        </label>
                    </div>
                    <p v-if="form.password && form.password_confirmation && form.password !== form.password_confirmation"
                        class="text-xs text-red-500 mt-1">
                        Passwords do not match.
                    </p>
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-md bg-primary text-secondary font-semibold hover:bg-secondary hover:text-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!form.terms || form.password !== form.password_confirmation">
                        Next
                    </button>
                </form>
            </div>
        </div>

        <div class="
                hidden
                md:flex
                items-center
                justify-center
                bg-light
                w-1/2
                min-h-screen
            ">
            <div class="text-gray-400 text-lg">
                <img src="/images/illustration/auth1.svg" alt="Illustration"
                    class="w-72 md:w-96 mr-0 md:mr-10 h-auto" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const form = useForm({
    first_name: '',
    last_name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

// Responsive: Detect tablet portrait mode
const isTabletPortrait = ref(false);

function checkTabletPortrait() {
    // 768px <= width < 1024px and portrait
    isTabletPortrait.value =
        window.innerWidth >= 768 &&
        window.innerWidth < 1024 &&
        window.matchMedia('(orientation: portrait)').matches;
}

onMounted(() => {
    checkTabletPortrait();
    window.addEventListener('resize', checkTabletPortrait);
    window.addEventListener('orientationchange', checkTabletPortrait);
});
onBeforeUnmount(() => {
    window.removeEventListener('resize', checkTabletPortrait);
    window.removeEventListener('orientationchange', checkTabletPortrait);
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>