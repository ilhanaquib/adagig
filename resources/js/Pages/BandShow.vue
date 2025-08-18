<template>
    <div class="bg-red">
        <Head :title="band.name" />

        <div class="w-full bg-light min-h-screen">
            <Navbar />

            <!-- Band Header -->
            <div class="w-full relative px-4 sm:px-8 lg:px-56">

                <!-- Wallpaper -->
                <div class="h-40 sm:h-48 md:h-56 w-full">
                    <img :src="band.wallpaper" alt="Wallpaper" class="w-full h-full object-cover" />
                </div>

                <!-- Info Section -->
                <div
                    class="bg-accent flex flex-col sm:flex-row sm:justify-between sm:items-start px-4 sm:px-8 md:px-12 lg:px-40 py-4 relative rounded-b-lg gap-4">

                    <!-- Left section (Logo + Text Info) -->
                    <div class="flex flex-col sm:flex-row">
                        <!-- Band Logo -->
                        <div class="absolute -top-10 left-4 sm:left-8 lg:left-40 bg-light rounded-full p-0.5 z-10">
                            <img :src="band.logo" alt="Band Logo"
                                class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full object-cover" />
                        </div>

                        <!-- Text Info -->
                        <div class="pt-8 sm:pt-0 sm:pl-24 md:pl-28 lg:pl-32">
                            <div>
                                <h1 class="text-light font-bold text-base sm:text-lg md:text-xl leading-tight">
                                    {{ band.name }}
                                </h1>
                                <h2 class="text-light text-xs sm:text-sm font-medium">
                                    {{ band.genre }}
                                </h2>
                            </div>

                            <!-- Description -->
                            <p class="text-light text-xs sm:text-sm mt-1">
                                {{ band.description || 'No description yet' }}
                            </p>

                            <!-- Location & Links -->
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-light text-xs sm:text-sm">
                                <div v-if="band.location" class="flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-xs">location_on</span>
                                    <span>{{ band.location }}</span>
                                </div>
                                <a v-if="band.links" :href="band.links" target="_blank"
                                    class="hover:underline font-medium">
                                    {{ shortLink(band.links) }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right section (Edit / Join) -->
                    <div class="flex flex-col">
                        <!-- If the logged-in user is a member -->
                        <div class="self-end">
                            <button v-if="isMember"
                                @click="showEditModal = true"
                                class="bg-primary text-secondary text-xs font-bold sm:text-sm px-3 py-1 rounded hover:bg-secondary hover:text-primary transition">
                                Edit
                            </button>

                            <!-- If not a member but logged in -->
                            <button v-else-if="authUser"
                                @click="joinBand"
                                class="bg-primary text-secondary text-xs font-bold sm:text-sm px-3 py-1 rounded hover:bg-secondary hover:text-primary transition">
                                Join
                            </button>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div v-if="showEditModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                            <BandUpdate :band="band" @close="showEditModal = false" />
                            <div class="mt-4 text-right">
                                <button @click="showEditModal = false"
                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Band Content -->
            <div class="pt-4 px-4 sm:px-8 lg:px-56">
                <!-- content navbar -->
                <div
                    class="bg-primary flex flex-wrap sm:flex-row items-center justify-between px-4 sm:px-6 rounded-t-lg overflow-x-auto">

                    <!-- Left: Links -->
                    <nav class="flex gap-4 sm:gap-6 whitespace-nowrap">
                        <Link>Posts</Link>
                        <Link>Music</Link>
                        <Link>Events</Link>
                        <Link>Merch</Link>
                        <Link>About</Link>
                    </nav>

                    <!-- Right: Add (only members see this) -->
                    <div v-if="isMember" class="m-2 flex-shrink-0">
                        <Link href="/bands/add"
                            class="w-8 h-8 flex items-center justify-center bg-secondary rounded-md hover:opacity-80 transition-colors">
                        <span class="material-symbols-outlined text-primary text-2xl">add</span>
                        </Link>
                    </div>
                </div>

                <!-- Band posts or content -->
                <div class="bg-accent flex justify-center rounded-b-lg p-4 sm:p-6">
                    <div v-for="(post, index) in posts" :key="index"
                        class="bg-white rounded-lg overflow-hidden shadow-lg w-full max-w-3xl mb-4">
                        <div class="bg-gray-200">
                            <img :src="post.image" alt="Post Image" class="w-full h-64 object-cover" />
                        </div>
                        <div class="p-4">
                            <p class="text-gray-700 mb-2">
                                {{ post.caption }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Navbar from '@/AdagigComponents/Navbar.vue';
import BandUpdate from './BandUpdate.vue';

const page = usePage()
const band = page.props.band
const authUser = page.props.authUser
const isMember = page.props.isMember || false
const posts = page.props.posts || []

const showEditModal = ref(false)

const joinBand = () => {
    router.post(`/bands/${band.id}/join`, {}, {
        onSuccess: () => window.location.reload()
    })
}

const shortLink = (url) => {
    if (!url) return ''
    try {
        const parsed = new URL(url)
        return parsed.hostname.replace(/^www\./, '')
    } catch (e) {
        return url
    }
}
</script>
