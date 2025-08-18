<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    organisations: Array
});

const organisations = ref(props.organisations);

const searchQuery = ref('');
const selectedLocation = ref('');
const sortOption = ref('nameAsc');

// Extract unique locations for filter dropdown
const locations = computed(() => {
    return [...new Set(organisations.value.map(o => o.location || 'Unknown'))];
});

const filteredOrganisations = computed(() => {
    let filtered = organisations.value;

    if (selectedLocation.value) {
        filtered = filtered.filter(o => o.location === selectedLocation.value);
    }

    if (searchQuery.value) {
        filtered = filtered.filter(o =>
            o.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            (o.location && o.location.toLowerCase().includes(searchQuery.value.toLowerCase()))
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

    <Head title="Organisations" />
    <Navbar />
    <div class="bg-light min-h-screen">
        <div class="max-w-7xl mx-auto p-4">
            <!-- Filters & Sorting -->
            <div class="flex flex-wrap gap-4 mb-6 items-center">
                <!-- Search -->
                <input v-model="searchQuery" type="text" placeholder="Search organisations..."
                    class="border border-gray-300 rounded px-3 py-2 w-full sm:w-64" />

                <!-- Location Filter -->
                <select v-model="selectedLocation" class="border border-gray-300 rounded py-2">
                    <option value="">All Locations</option>
                    <option v-for="loc in locations" :key="loc" :value="loc">{{ loc }}</option>
                </select>

                <!-- Sorting -->
                <select v-model="sortOption" class="border border-gray-300 rounded py-2">
                    <option value="nameAsc">Name A-Z</option>
                    <option value="nameDesc">Name Z-A</option>
                    <option value="locationAsc">Location A-Z</option>
                    <option value="locationDesc">Location Z-A</option>
                </select>
            </div>

            <!-- Organisations Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div v-for="(org, index) in filteredOrganisations" :key="index"
                    class="relative bg-primary rounded-lg shadow overflow-hidden group">
                    <Link :href="`/organisations/${org.name}`">
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-primary text-secondary p-2 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-in-out">
                        <h3 class="text-md font-semibold">{{ org.name }}</h3>
                        <p class="text-xs text-gray-500">{{ org.location }}</p>
                    </div>
                    <img :src="org.logo || '/images/org-placeholder.png'" alt="Organisation Logo"
                        class="w-full h-full object-cover" />
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
