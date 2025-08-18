<template>
    <div class="bg-red">

        <Head :title="organisation.name" />

        <div class="w-full bg-light min-h-screen">
            <Navbar />

            <!-- Organisation Header -->
            <div class="w-full relative px-4 sm:px-8 lg:px-56">

                <!-- Wallpaper -->
                <div class="h-40 sm:h-48 md:h-56 w-full">
                    <img :src="organisation.wallpaper" alt="Wallpaper" class="w-full h-full object-cover" />
                </div>

                <!-- Info Section -->
                <div
                    class="bg-accent flex flex-col sm:flex-row sm:justify-between sm:items-start px-4 sm:px-8 md:px-12 lg:px-40 py-4 relative rounded-b-lg gap-4">

                    <!-- Left section (Logo + Text Info) -->
                    <div class="flex flex-col sm:flex-row">
                        <!-- Logo -->
                        <div class="absolute -top-10 left-4 sm:left-8 lg:left-40 bg-light rounded-full p-0.5 z-10">
                            <img :src="organisation.logo" alt="Organisation Logo"
                                class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full object-cover" />
                        </div>

                        <!-- Text Info -->
                        <div class="pt-8 sm:pt-0 sm:pl-24 md:pl-28 lg:pl-32">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h1 class="text-light font-bold text-base sm:text-lg md:text-xl leading-tight">
                                        {{ organisation.name }}
                                    </h1>
                                </div>

                                <!-- Location -->
                                <h2 v-if="organisation.location" class="text-light text-xs sm:text-sm font-medium">
                                    {{ organisation.location }}
                                </h2>
                            </div>

                            <!-- Description -->
                            <p class="text-light text-xs sm:text-sm mt-1">
                                {{ organisation.description || 'No description yet' }}
                            </p>

                            <!-- Links -->
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-light text-xs sm:text-sm">
                                <a v-if="organisation.links" :href="organisation.links" target="_blank"
                                    class="hover:underline font-medium">
                                    {{ shortLink(organisation.links) }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right section -->
                    <div class="flex flex-col ">
                        <!-- Edit / Join Button -->
                        <div class="self-end">
                            <!-- Show Edit button if I am part of this organisation -->
                            <button v-if="isMember" @click="showEditModal = true"
                                class="bg-primary text-secondary text-xs font-bold sm:text-sm px-3 py-1 rounded hover:bg-secondary hover:text-primary transition">
                                Edit Organisation
                            </button>

                            <!-- Show Join button if not a member -->
                            <button v-else-if="authUser" @click="joinOrganisation"
                                class="bg-primary text-secondary text-xs font-bold sm:text-sm px-3 py-1 rounded hover:bg-secondary hover:text-primary transition">
                                Join
                            </button>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div v-if="showEditModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                            <OrganisationUpdate :organisation="organisation" @close="showEditModal = false" />
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

            <!-- Organisation Content -->
            <div class="pt-4 px-4 sm:px-8 lg:px-56">
                <!-- Content Nav -->
                <div
                    class="bg-primary flex flex-wrap sm:flex-row items-center justify-between px-4 sm:px-6 rounded-t-lg overflow-x-auto">

                    <!-- Left: Links -->
                    <nav class="flex gap-4 sm:gap-6 whitespace-nowrap">
                        <Link>Posts</Link>
                        <Link>Events</Link>
                        <Link>Members</Link>
                        <Link>About</Link>
                    </nav>

                    <!-- Right: Add -->
                    <div v-if="isMember" class="m-2 flex-shrink-0">
                        <Link href="/organisations/add"
                            class="w-8 h-8 flex items-center justify-center bg-secondary rounded-md hover:opacity-80 transition-colors">
                        <span class="material-symbols-outlined text-primary text-2xl">add</span>
                        </Link>
                    </div>
                </div>

                <!-- Placeholder content -->
                <div class="bg-accent flex justify-center rounded-b-lg p-4 sm:p-6">
                    <p class="text-light">Organisation content goes here...</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/AdagigComponents/Navbar.vue';
import OrganisationUpdate from './OrganisationUpdate.vue';

const page = usePage()
const organisation = page.props.organisation
const authUser = page.props.authUser // logged-in user (or null if guest)

const showEditModal = ref(false)

// check if logged in user is part of this organisation
const isMember = computed(() => {
    if (!authUser) return false
    return organisation.users?.some(user => user.id === authUser.id)
})

// join org
const joinOrganisation = () => {
    router.post(`/organisations/${organisation.id}/join`, {}, {
        onSuccess: () => {
            // update state after joining
            organisation.users.push(authUser)
        }
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
