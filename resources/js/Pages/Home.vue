<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Carousel from '@/Components/Carousel.vue';
import { ref, computed } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faBars, faEnvelope, faPhone } from '@fortawesome/free-solid-svg-icons';
import { faInstagram, faTwitter } from '@fortawesome/free-brands-svg-icons';

const sidebarRef = ref(null);
const sidebarIsOpen = computed(() => sidebarRef.value?.isOpen);

const toggleSidebarHome = () => {
    // Call the `toggleSidebar` method on the Sidebar component
    sidebarRef.value.toggleSidebar();
};

</script>

<template>

    <Head title="Home" />

    <header>
        <div class="container mx-auto  bg-black min-h-80">
            <div v-if="!sidebarIsOpen" class="flex justify-left items-end ml-16 relative py-8">
                <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
                <FontAwesomeIcon class="text-2xl" :style="{ color: 'white' }" :icon="faBars"
                    @click="toggleSidebarHome" />
            </div>
        </div>
    </header>

    <Sidebar ref="sidebarRef" />

    <body>
        <Carousel />
        <Carousel />
    </body>

    <footer>
        <div class="container mx-auto bg-black min-h-40 flex items-center justify-between px-4">
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
                    <FontAwesomeIcon  class="text-xl pr-4" :style="{ color: 'white' }" :icon="faTwitter" />
                    </Link>
                    <Link href="">
                    <FontAwesomeIcon class="text-xl" :style="{ color: 'white' }" :icon="faInstagram" />
                    </Link>
                </div>
            </div>
        </div>

    </footer>
</template>
