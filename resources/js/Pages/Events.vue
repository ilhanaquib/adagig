<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    events: Array
});

// Use the events from props instead of hardcoded
const events = ref(props.events);

const searchQuery = ref('');
const selectedCategory = ref('');
const sortOption = ref('dateAsc');

const categories = computed(() => {
    return [...new Set(events.value.map(e => e.category))];
});

const filteredEvents = computed(() => {
    let filtered = events.value;

    if (selectedCategory.value) {
        filtered = filtered.filter(e => e.category === selectedCategory.value);
    }

    if (searchQuery.value) {
        filtered = filtered.filter(e =>
            e.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            e.venue.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    }

    if (sortOption.value === 'dateAsc') {
        filtered = filtered.slice().sort((a, b) => new Date(a.date) - new Date(b.date));
    } else if (sortOption.value === 'dateDesc') {
        filtered = filtered.slice().sort((a, b) => new Date(b.date) - new Date(a.date));
    } else if (sortOption.value === 'titleAsc') {
        filtered = filtered.slice().sort((a, b) => a.title.localeCompare(b.title));
    } else if (sortOption.value === 'titleDesc') {
        filtered = filtered.slice().sort((a, b) => b.title.localeCompare(a.title));
    }

    return filtered;
});
</script>


<template>

    <Head title="Events" />
    <Navbar />
    <div class="bg-light min-h-screen">
        <div class="max-w-7xl mx-auto p-4">
            <!-- Filters & Sorting -->
            <div class="flex flex-wrap gap-4 mb-6 items-center">
                <!-- Search -->
                <input v-model="searchQuery" type="text" placeholder="Search events..."
                    class="border border-gray-300 rounded px-3 py-2 w-full sm:w-64" />

                <!-- Category Filter -->
                <select v-model="selectedCategory" class="border border-gray-300 rounded py-2">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
                </select>

                <!-- Sorting -->
                <select v-model="sortOption" class="border border-gray-300 rounded py-2">
                    <option value="dateAsc">Date ↑</option>
                    <option value="dateDesc">Date ↓</option>
                    <option value="titleAsc">Title A-Z</option>
                    <option value="titleDesc">Title Z-A</option>
                </select>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4  gap-3">
                <div v-for="(event, index) in filteredEvents" :key="index"
                    class="relative bg-primary rounded-lg shadow overflow-hidden group cursor-pointer">
                    <img :src="event.image" alt="" class="w-full h-full object-cover" />
                    <!-- Event details sliding up -->
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-primary text-secondary p-2 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-in-out">
                        <h3 class="text-md font-semibold">{{ event.title }}</h3>
                        <p class="text-xs text-gray-500">{{ event.date }} • {{ event.venue }}</p>
                        <!-- Uncomment if you want category -->
                        <!-- <p class="mt-0.5 text-[10px] text-gray-400">{{ event.category }}</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
