<template>
    <div class="bg-red">

        <Head title="Profile" />

        <div class="w-full bg-light min-h-screen">
            <Navbar />

            <!-- Profile Header -->
            <div class="w-full relative px-40">

                <!-- Wallpaper -->
                <div class="h-24 sm:h-28 w-full">
                    <img src="/images/wallpaper.jpg" alt="Wallpaper" class="w-full h-full object-cover" />
                </div>

                <!-- Info Section -->
                <div class="bg-accent flex items-center px-6 sm:px-10 md:px-40 py-4 relative rounded-b-lg">

                    <!-- Profile Picture -->
                    <div class="absolute -top-10 left-6 sm:left-10 md:left-40 bg-light rounded-full p-0.5 z-10">
                        <img src="/images/flaglogo.png" alt="Profile Picture"
                            class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full object-cover" />
                    </div>

                    <!-- Text Info -->
                    <div class="pl-20 sm:pl-28 md:pl-32">
                        <!-- Name & Username -->
                        <h1 class="text-light font-bold text-base sm:text-lg md:text-xl leading-tight">
                            {{ firstName }} {{ lastName }}
                        </h1>
                        <h2 class="text-light text-xs sm:text-sm font-medium">@{{ username }}</h2>

                        <!-- Bio -->
                        <p class="text-light text-xs sm:text-sm mt-1">
                            Developer of Adagig
                        </p>

                        <!-- Following / Followers -->
                        <div class="flex space-x-3 mt-1 text-xs sm:text-sm">
                            <div><span class="font-bold">120</span> Following</div>
                            <div><span class="font-bold">980</span> Followers</div>
                        </div>

                        <!-- Location & Links -->
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs sm:text-sm">
                            <div class="flex items-center space-x-1">
                                <span class="material-symbols-outlined text-xs">location_on</span>
                                <span>San Francisco, CA</span>
                            </div>
                            <a href="https://example.com" target="_blank"
                                class="hover:underline font-medium">Website</a>
                            <a href="https://github.com/username" target="_blank"
                                class="hover:underline font-medium">GitHub</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- content -->
            <div class="pt-4 px-4 sm:px-8 lg:px-40">
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
                    <!-- Post Card -->
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-lg w-full max-w-3xl grid grid-cols-1 md:grid-cols-2">
                        <!-- Left: Image -->
                        <div class="bg-gray-200">
                            <img src="/images/sample.jpg" alt="Post Image" class="w-full h-full object-cover" />
                        </div>

                        <!-- Right: Post Details -->
                        <div class="p-4 flex flex-col justify-between">
                            <!-- Caption -->
                            <div>
                                <h3 class="text-lg font-semibold mb-2">Post Title</h3>
                                <p class="text-gray-700 mb-4">
                                    This is a sample post content. It can be a short description or an update.
                                </p>
                            </div>

                            <!-- Likes & Comments -->
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
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Navbar from '@/AdagigComponents/Navbar.vue';

const page = usePage()
const username = page.props.auth.user?.username
const firstName = page.props.auth.user?.first_name
const lastName = page.props.auth.user?.last_name
</script>
