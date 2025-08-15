<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import logo from '/public/images/textlogo.png';

const page = usePage()
const username = page.props.auth.user?.username
const userid = page.props.auth.user?.id

const mobileOpen = ref(false)
</script>

<!-- TODO change person icon to image with placeholder -->
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
                    <Link href="/artists" class="hover:text-secondary">Artists</Link>
                </div>

                <!-- Username + Icon (Desktop) -->
                <div class="hidden md:flex items-center space-x-3" v-if="username">
                    <Link :href="`/profile/${userid}`"><span>{{ username }}</span>
                    </Link>
                    <span class="material-symbols-outlined">person</span>
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

                <div v-if="username" class="flex items-center space-x-3 mt-2">
                    <span>{{ username }}</span>
                    <span class="material-symbols-outlined text-3xl">person</span>
                </div>
            </div>
        </nav>
    </div>
</template>
