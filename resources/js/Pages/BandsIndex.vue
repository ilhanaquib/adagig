<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    bands: Array
});

const bands = ref(props.bands);

const searchQuery = ref('');
const selectedGenre = ref('');
const sortOption = ref('nameAsc');

// Extract genres for filter dropdown
const genres = computed(() => {
    return [...new Set(bands.value.map(b => b.genre || 'Uncategorized'))];
});

const filteredBands = computed(() => {
    let filtered = bands.value;

    if (selectedGenre.value) {
        filtered = filtered.filter(b => b.genre === selectedGenre.value);
    }

    if (searchQuery.value) {
        filtered = filtered.filter(b =>
            b.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            (b.location && b.location.toLowerCase().includes(searchQuery.value.toLowerCase()))
        );
    }

    if (sortOption.value === 'nameAsc') {
        filtered = filtered.slice().sort((a, b) => a.name.localeCompare(b.name));
    } else if (sortOption.value === 'nameDesc') {
        filtered = filtered.slice().sort((a, b) => b.name.localeCompare(a.name));
    } else if (sortOption.value === 'locationAsc') {
        filtered = filtered.slice().sort((a, b) => (a.location || '').localeCompare(b.location || ''));
    } else if (sortOption.value === 'locationDesc') {
        filtered = filtered.slice().sort((a, b) => (b.location || '').localeCompare(a.location || ''));
    }

    return filtered;
});
</script>

<template>

    <Head title="Bands" />
    <Navbar />
    <div class="bg-light min-h-screen">
        <div class="max-w-7xl mx-auto p-4">
            <!-- Filters & Sorting -->
            <div class="flex flex-wrap gap-4 mb-6 items-center">
                <!-- Search -->
                <input v-model="searchQuery" type="text" placeholder="Search bands..."
                    class="border border-gray-300 rounded px-3 py-2 w-full sm:w-64" />

                <!-- Genre Filter -->
                <select v-model="selectedGenre" class="border border-gray-300 rounded py-2">
                    <option value="">All Genres</option>
                    <option v-for="genre in genres" :key="genre" :value="genre">{{ genre }}</option>
                </select>

                <!-- Sorting -->
                <select v-model="sortOption" class="border border-gray-300 rounded py-2">
                    <option value="nameAsc">Name A-Z</option>
                    <option value="nameDesc">Name Z-A</option>
                    <option value="locationAsc">Location A-Z</option>
                    <option value="locationDesc">Location Z-A</option>
                </select>
            </div>

            <!-- Bands Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div v-for="(band, index) in filteredBands" :key="index"
                    class="relative bg-primary rounded-lg shadow overflow-hidden group">
                    <Link :href="`/bands/${band.name}`">
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-primary text-secondary p-2 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-in-out">
                        <h3 class="text-md font-semibold">{{ band.name }}</h3>
                        <p class="text-xs text-gray-500">{{ band.genre }} • {{ band.location }}</p>
                    </div>
                    <img :src="band.logo" alt="Band Logo" class="w-full h-full object-cover" />
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
