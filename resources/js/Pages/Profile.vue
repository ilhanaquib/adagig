<template>
    <div class="bg-red">

        <Head title="Profile" />

        <div class="w-full bg-light min-h-screen">
            <Navbar />

            <!-- Profile Header -->
            <div class="w-full relative px-4 sm:px-8 lg:px-56">

                <!-- Wallpaper -->
                <div class="h-40 sm:h-48 md:h-56 w-full">
                    <img :src="profile.wallpaper" alt="Wallpaper" class="w-full h-full object-cover" />
                </div>

                <!-- Info Section -->
                <div
                    class="bg-accent flex flex-col sm:flex-row sm:justify-between sm:items-start px-4 sm:px-8 md:px-12 lg:px-40 py-4 relative rounded-b-lg gap-4">

                    <!-- Left section (Profile Picture + Text Info) -->
                    <div class="flex flex-col sm:flex-row">
                        <!-- Profile Picture -->
                        <div class="absolute -top-10 left-4 sm:left-8 lg:left-40 bg-light rounded-full p-0.5 z-10">
                            <img :src="profile.profile_picture" alt="Profile Picture"
                                class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full object-cover" />
                        </div>

                        <!-- Text Info -->
                        <div class="pt-8 sm:pt-0 sm:pl-24 md:pl-28 lg:pl-32">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h1 class="text-light font-bold text-base sm:text-lg md:text-xl leading-tight">
                                        {{ user.first_name }} {{ user.last_name }}
                                    </h1>
                                    <div class="rounded-xl bg-primary text-secondary font-bold px-2 py-0.5 text-xs">
                                        {{ user.roles.join(', ') }}
                                    </div>
                                </div>

                                <h2 class="text-light text-xs sm:text-sm font-medium">@{{ user.username }}</h2>
                            </div>

                            <!-- Bio -->
                            <p class="text-light text-xs sm:text-sm mt-1">
                                {{ profile.bio || 'No bio yet' }}
                            </p>

                            <!-- Following / Followers -->
                            <div class="flex flex-wrap gap-x-3 mt-1 text-light text-xs sm:text-sm">
                                <div><span class="font-bold">{{ page.props.followingCount }}</span> Following</div>
                                <div><span class="font-bold">{{ page.props.followersCount }}</span> Followers</div>
                            </div>
                            <!-- Location & Links -->
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-light text-xs sm:text-sm">
                                <div v-if="profile.location" class="flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-xs">location_on</span>
                                    <span>{{ profile.location }}</span>
                                </div>
                                <!-- <a v-if="profile.links" :href="profile.links" target="_blank"
                                    class="hover:underline font-medium">
                                    {{ shortLink(profile.links) }}
                                </a> -->
                            </div>
                        </div>
                    </div>

                    <!-- Right section (Edit button) -->
                    <div class="flex flex-col ">
                        <!-- Edit / Follow Button (right aligned) -->
                        <div class="self-end">
                            <!-- Edit button if it’s my profile -->
                            <button v-if="authUser && user.id === authUser.id" @click="showEditModal = true"
                                class="bg-primary text-secondary text-xs font-bold sm:text-sm px-3 py-1 rounded hover:bg-secondary hover:text-primary transition">
                                Edit
                            </button>

                            <!-- Follow/Following if viewing another profile -->
                            <button v-else-if="authUser" @click="following ? unfollow() : follow()"
                                class="bg-primary text-secondary text-xs font-bold sm:text-sm px-3 py-1 rounded hover:bg-secondary hover:text-primary transition">
                                {{ following ? 'Following' : 'Follow' }}
                            </button>
                        </div>

                        <!-- Group -->
                        <div class="mt-4 rounded-lg text-secondary">
                            <div class="flex flex-wrap gap-2 max-h-32 overflow-y-auto scrollbar-hide">

                                <!-- Bands -->
                                <template v-for="band in bands" :key="band.id">
                                    <span
                                        class="px-3 py-1 rounded-full bg-secondary text-primary text-xs font-semibold flex items-center gap-2">
                                        <img :src="band.logo" alt="Band Logo" class="w-4 h-4 rounded-full" />
                                        {{ band.name }}
                                    </span>
                                </template>

                                <!-- Organisations -->
                                <template v-for="org in organisations" :key="org.id">
                                    <span
                                        class="px-3 py-1 rounded-full bg-secondary text-primary text-xs font-semibold flex items-center gap-2">
                                        <img :src="org.logo" alt="Organisation Logo" class="w-4 h-4 rounded-full" />
                                        {{ org.name }}
                                    </span>
                                </template>

                                <!-- Add button -->
                                <button @click="showGroupModal = true"
                                    class="px-3 py-1 rounded-full bg-secondary text-primary text-xs font-semibold hover:bg-primary hover:text-secondary transition">
                                    + Add
                                </button>
                            </div>
                        </div>

                    </div>

                    <div v-if="showEditModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                            <ProfileUpdate @close="showEditModal = false" />
                            <div class="mt-4 text-right">
                                <button @click="showEditModal = false"
                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-if="showGroupModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
                            <AddGroup @close="showGroupModal = false" />
                            <div class="mt-4 text-right">
                                <button @click="showGroupModal = false"
                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- content -->
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

                    <!-- Right: Add -->
                    <div class="m-2 flex-shrink-0">
                        <Link href="/add"
                            class="w-8 h-8 flex items-center justify-center bg-secondary rounded-md hover:opacity-80 transition-colors">
                        <span class="material-symbols-outlined text-primary text-2xl">add</span>
                        </Link>
                    </div>
                </div>

                <!-- content grid -->
                <div class="bg-accent flex justify-center rounded-b-lg p-4 sm:p-6">
                    <div v-for="(post, index) in posts" :key="index"
                        class="bg-accent flex justify-center rounded-b-lg p-4 sm:p-6">
                        <!-- Post Card -->
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow-lg w-full max-w-3xl grid grid-cols-1 md:grid-cols-2">
                            <!-- Left: Image -->
                            <div class="bg-gray-200">
                                <img :src="post.image" alt="Post Image" class="w-full h-full object-cover" />
                            </div>

                            <!-- Right: Post Details -->
                            <div class="p-4 flex flex-col justify-between">
                                <!-- Caption -->
                                <div>
                                    <p class="text-gray-700 mb-4">
                                        {{ post.caption }}
                                    </p>
                                </div>

                                <!-- Likes & Comments (Hardcoded for now) -->
                                <div class="flex items-center space-x-4 mt-4">
                                    <div class="flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-gray-500">thumb_up</span>
                                        <span class="text-gray-500">120</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <span class="material-symbols-outlined text-gray-500">comment</span>
                                        <span class="text-gray-500">45</span>
                                    </div>
                                </div>
                            </div>
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
import ProfileUpdate from './ProfileUpdate.vue';
import AddGroup from '@/AdagigComponents/AddGroup.vue';

const page = usePage()
const user = page.props.user
const profile = page.props.profile
const posts = page.props.posts || []
const bands = page.props.bands || []
const organisations = page.props.organisations || []
const following = ref(page.props.isFollowing)
const authUser = page.props.authUser // logged-in user (or null if guest)

const showEditModal = ref(false)
const showGroupModal = ref(false)

const follow = () => {
    router.post(`/users/${user.id}/follow`, {}, {
        onSuccess: () => following.value = true
    })
}

const unfollow = () => {
    router.delete(`/users/${user.id}/unfollow`, {
        onSuccess: () => following.value = false
    })
}


const shortLink = (url) => {
    if (!url) return ''
    try {
        const parsed = new URL(url)
        return parsed.hostname.replace(/^www\./, '') // remove www.
    } catch (e) {
        // if URL() parsing fails, return raw string
        return url
    }
}
</script>
