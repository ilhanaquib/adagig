<template>

    <Header>
        <div v-if="!sidebarIsOpen" class="flex itemsnt-end h-8 w-auto px-4 absolute top-4 left-4 items-end">
            <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
            <FontAwesomeIcon class="text-2xl" :style="{ color: 'black' }" :icon="faBars" @click="toggleSidebarHome" />
        </div>
    </Header>

    <Sidebar ref="sidebarRef" />

    <body>

    </body>

    <footer>
        <Footer />
    </footer>

</template>

<script setup>
import Sidebar from '@/Components/AdagigComponents/Sidebar.vue';
import Footer from '@/Components/AdagigComponents/Footer.vue';

const sidebarRef = ref(null);
const sidebarIsOpen = computed(() => sidebarRef.value?.isOpen);

const toggleSidebarHome = () => {
    sidebarRef.value.toggleSidebar();
};
</script>