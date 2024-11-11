<script setup>
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/AdagigComponents/Sidebar.vue';
import { ref, computed } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faBars } from '@fortawesome/free-solid-svg-icons';
import HomeEventCarousel from '@/Components/AdagigComponents/HomeEventCarousel.vue';
import HeaderEventCarousel from '@/Components/AdagigComponents/HeaderEventCarousel.vue';
import Footer from '@/Components/AdagigComponents/Footer.vue';

const props = defineProps({
    events: Array
});

const sidebarRef = ref(null);
const sidebarIsOpen = computed(() => sidebarRef.value?.isOpen);

const toggleSidebarHome = () => {
    sidebarRef.value.toggleSidebar();
};

</script>

<template>

    <Head title="Home" />


    <header class="relative">
        <HeaderEventCarousel :events="events" />
        <div v-if="!sidebarIsOpen" class="flex itemsnt-end h-8 w-auto px-4 absolute top-4 left-4 items-end">
            <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
            <FontAwesomeIcon class="text-2xl" :style="{ color: 'white' }" :icon="faBars" @click="toggleSidebarHome" />
        </div>
    </header>

    <Sidebar ref="sidebarRef" />

    <body>
        <HomeEventCarousel :events="events" />
    </body>

    <footer>
        <Footer />
    </footer>
</template>
