<template>
    <div class="flex flex-col min-h-screen">
        <header class="bg-black flex items-end align-center px-8 py-12 top-0 left-0 w-full">
            <div v-if="!sidebarIsOpen" class="flex items-end absolute top-8 left-8">
                <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
                <FontAwesomeIcon class="text-2xl" :style="{ color: 'white' }" :icon="faBars"
                    @click="toggleSidebarHome" />
            </div>
        </header>

        <Sidebar ref="sidebarRef" />

        <main class="flex-grow px-64 py-12">
            <slot></slot>
        </main>

        <footer>
            <Footer />
        </footer>
    </div>
</template>


<script setup>
import { ref, computed } from 'vue';
import Sidebar from '@/Components/AdagigComponents/Sidebar.vue';
import Footer from '@/Components/AdagigComponents/Footer.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBars } from '@fortawesome/free-solid-svg-icons';

const sidebarRef = ref(null);
const sidebarIsOpen = computed(() => sidebarRef.value?.isOpen);

const toggleSidebarHome = () => {
    sidebarRef.value.toggleSidebar();
};
</script>
