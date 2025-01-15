<script setup>
import { Link } from '@inertiajs/vue3'
import HeaderEventCarousel from '@/Components/AdagigComponents/HeaderEventCarousel.vue';
import Sidebar from '@/Components/AdagigComponents/Sidebar.vue';
import { ref, computed } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faBars } from '@fortawesome/free-solid-svg-icons';
import Footer from '@/Components/AdagigComponents/Footer.vue';

const props = defineProps({
    events: Array
});

const hoveredEvent = ref(null)

const sidebarRef = ref(null);
const sidebarIsOpen = computed(() => sidebarRef.value?.isOpen);

const toggleSidebarHome = () => {
    sidebarRef.value.toggleSidebar();
};
</script>

<template>
    <div>
        <HeaderEventCarousel :events="events" />
        <div v-if="!sidebarIsOpen" class="flex itemsnt-end h-8 w-auto px-4 absolute top-4 left-4 items-end">
            <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
            <FontAwesomeIcon class="text-2xl" :style="{ color: 'white' }" :icon="faBars" @click="toggleSidebarHome" />
        </div>
    </div>

    <Sidebar ref="sidebarRef" />

    <div class="container m-auto grid grid-cols-3 mt-12 ml-24 mr-12">
        <div v-for="(event, index) in events" :key="index" class="hs-carousel-slide flex w-80 h-80 "
            @mouseenter="hoveredEvent = index" @mouseleave="hoveredEvent = null">
            <Link :href="route('event.show', { id: event.id })"
                class="relative flex justify-center h-full w-full dark:bg-neutral-900">
            <img :src="event.poster" alt="" class="w-full object-cover mb-8 rounded-lg">
            <div v-if="hoveredEvent === index"
                class="absolute bottom-8 inset-0 bg-gradient-to-t from-black to-transparent opacity-70 rounded-lg flex items-end p-4">
                <div class="flex flex-col">
                    <div class="text-white font-semibold">{{ event.name }}</div>
                    <div class="text-white">{{ event.description }}</div>
                </div>
            </div>
            </Link>
        </div>
    </div>

    <Footer />
</template>
