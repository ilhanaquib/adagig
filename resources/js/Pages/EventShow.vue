<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    event: Object
});
</script>

<template>

    <Head :title="props.event.title" />

    <Navbar />
    <div class="bg-light min-h-screen flex flex-col md:flex-row">
        <!-- Left half -->
        <div class="md:w-1/2 flex justify-center items-start p-8">
            <img :src="props.event.image" alt="poster"
                class="rounded-lg shadow-lg w-full max-w-md object-cover aspect-[2/3]" />
        </div>

        <!-- Right half -->
        <div class="md:w-1/2 p-8 flex flex-col justify-start pt-16 space-y-4">
            <h1 class="text-3xl font-bold mb-12 ">{{ props.event.title }}</h1>
            <p class="whitespace-pre-line text-xl">{{ props.event.description }}</p>
            <p class="text-lg font-bold pb-2">{{ new Date(props.event.date).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'long', year: 'numeric'
            }) }}
                • {{ props.event.venue }}</p>

            <div>
                <a :href="props.event.ticket_url" target="_blank"
                    class="inline-block bg-primary text-secondary px-5 py-2 rounded-lg font-semibold transition hover:opacity-90 text-sm sm:text-base">
                    Get Tickets
                </a>
            </div>
        </div>
    </div>
</template>