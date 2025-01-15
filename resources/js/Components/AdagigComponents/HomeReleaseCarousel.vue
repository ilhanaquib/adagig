<template>
    <div class="mt-8 mx-8 text-xl justify-start font-medium">
        New Releases
    </div>

    <div class="mx-4 mt-4 mb-8 grid grid-cols-8 grid-rows-2 gap-2">
        <div v-for="(event, index) in events" :key="index" :class="index === 0 ? 'col-span-2 row-span-2' : ''"
            class=" rounded-lg">
            <img :src="event.poster" alt="" class="w-full h-full object-cover rounded-lg" />
        </div>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3'


const props = defineProps({
    events: Array
});

const hover = ref(false);
const hoveredEvent = ref(null)
</script>