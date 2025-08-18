<script setup>
import { ref } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import logo from '/public/images/textlogo.png';

const page = usePage()
const username = page.props.auth.user?.username
const userid = page.props.auth.user?.id

const mobileOpen = ref(false)
const dropdownOpen = ref(false)

const logout = () => {
    router.post('/logout')
}
</script>

<template>
    <div class="flex flex-col">
        <nav class="bg-primary px-6 md:px-16">
            <div class="flex items-center justify-between h-12">

                <!-- Logo -->
                <Link href="/" class="flex items-center">
                <img :src="logo" class="w-24" alt="Logo" />
                </Link>

                <!-- Desktop Links -->
                <div class="hidden md:flex space-x-6 font-medium">
                    <Link href="/" class="hover:text-secondary">Home</Link>
                    <Link href="/events" class="hover:text-secondary">Event</Link>
                    <Link href="/bands" class="hover:text-secondary">Bands</Link>
                    <Link href="/organisations" class="hover:text-secondary">Organisations</Link>
                    <Link href="/artists" class="hover:text-secondary">Artists</Link>
                </div>

                <!-- Username + Dropdown (Desktop) -->
                <div v-if="username" class="hidden md:flex items-center space-x-2 relative"
                    @mouseover="dropdownOpen = true" @mouseleave="dropdownOpen = false">

                    <span class="cursor-pointer">{{ username }}</span>
                    <span class="material-symbols-outlined cursor-pointer">person</span>

                    <div v-show="dropdownOpen"
                        class="absolute top-full right-0 mt-2 w-40 bg-white text-black rounded shadow-lg py-2 z-50">
                        <Link :href="`/profile`" class="block px-4 py-2 hover:bg-gray-100">
                        Profile
                        </Link>
                        <button @click="logout" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                            Logout
                        </button>
                    </div>
                </div>


                <!-- Mobile Menu Button -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden flex items-center focus:outline-none">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-if="mobileOpen" class="flex flex-col space-y-4 mt-4 md:hidden font-medium">
                <Link href="/" class="hover:text-secondary">Home</Link>
                <Link href="/events" class="hover:text-secondary">Event</Link>
                <Link href="/artists" class="hover:text-secondary">Artists</Link>

                <!-- Username + Dropdown (Mobile/Tablet) -->
                <div v-if="username" class="flex flex-col space-y-2 mt-2 relative">
                    <div @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 cursor-pointer">
                        <span>{{ username }}</span>
                        <span class="material-symbols-outlined text-3xl">person</span>
                    </div>

                    <!-- Dropdown -->
                    <div v-show="dropdownOpen"
                        class="flex flex-col bg-white text-black rounded shadow-lg mt-2 py-2 z-50">
                        <Link :href="`/profile/${userid}`" class="block px-4 py-2 hover:bg-gray-100">
                        Profile
                        </Link>
                        <button @click="logout" class="text-left px-4 py-2 hover:bg-gray-100">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
