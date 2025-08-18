<script setup>
import { ref, watch } from "vue";
import { router, Link } from "@inertiajs/vue3";

const search = ref("");
const results = ref([]);
const loading = ref(false);
let timeout = null;

// Fetch bands from backend (e.g., route: bands.search)
const fetchBands = () => {
    if (!search.value) {
        results.value = [];
        return;
    }

    loading.value = true;

    router.get(
        route("bands.search"), // <-- You’ll need to define this route
        { q: search.value },
        {
            preserveState: true,
            replace: true,
            only: ["bands"],
            onSuccess: (page) => {
                results.value = page.props.bands || [];
            },
            onFinish: () => {
                loading.value = false;
            },
        }
    );
};

// Debounce search
watch(search, (newValue) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        fetchBands();
    }, 400);
});

// Handle create band click
const createBand = () => {
    // Open another modal OR redirect to create form
    router.visit(route("bands.create"));
};
</script>

<template>
    <div class="p-4">
        <!-- Search -->
        <input v-model="search" type="text" placeholder="Search bands..."
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />

        <!-- Loading indicator -->
        <div v-if="loading" class="mt-2 text-gray-500">Searching...</div>

        <!-- Results -->
        <ul v-if="results.length" class="mt-2 space-y-1">
            <li v-for="band in results" :key="band.id" class="p-2 rounded hover:bg-gray-100 cursor-pointer">
                {{ band.name }}
            </li>
        </ul>

        <!-- No results -->
        <div v-else-if="search && !loading" class="mt-2 text-gray-500">
            No bands found
        </div>

        <!-- Create Button -->
        <Link :href="route('group.create')"
            class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
        + Create Band
        </Link>
    </div>
</template>
