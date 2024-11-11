<template>
    <div class="w-full bg-black min-h-40 flex items-center justify-between px-4">
        <!-- Left Side Content -->
        <div class="text-white flex px-32">
            <div name="sitemap" class="flex flex-col space-y-2 px-20">
                <Link href="">Home</Link>
                <Link href="">Event</Link>
                <Link href="">About Us</Link>
            </div>

            <div name="reachUs" class="flex flex-col space-y-2">
                <p>Reach Us</p>
                <Link href="">
                <FontAwesomeIcon class="pr-4" :style="{ color: 'white' }" :icon="faEnvelope" />
                adagig@gmail.com
                </Link>
                <Link href="">
                <FontAwesomeIcon class="pr-4" :style="{ color: 'white' }" :icon="faPhone" />
                +60123456789
                </Link>
            </div>
        </div>

        <!-- Right Side Content -->
        <div class="text-white flex flex-col px-72">
            <div name="connect" class=" space-y-2">
                <p>Connect With Us</p>
                <Link href="">
                <FontAwesomeIcon class="text-xl pr-4" :style="{ color: 'white' }" :icon="faTwitter" />
                </Link>
                <Link href="">
                <FontAwesomeIcon class="text-xl" :style="{ color: 'white' }" :icon="faInstagram" />
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { faInstagram, faTwitter } from '@fortawesome/free-brands-svg-icons';
import { Link } from '@inertiajs/vue3';
import { faEnvelope, faPhone } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
</script>