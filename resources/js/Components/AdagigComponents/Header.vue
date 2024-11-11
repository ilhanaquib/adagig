<template>
        <div v-if="!sidebarIsOpen" class="flex itemsnt-end h-8 w-auto px-4 absolute top-4 left-4 items-end">
            <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
            <FontAwesomeIcon class="text-2xl" :style="{ color: 'black' }" :icon="faBars" @click="toggleSidebarHome" />
        </div>
</template>

<script setup>
</script>