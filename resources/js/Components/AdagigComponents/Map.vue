<template>
    <div>
        <label for="location">Location:</label>
        <input id="location" v-model="searchQuery" @input="fetchAddressSuggestions" @blur="clearSuggestionsWithDelay"
            class="border rounded-md w-full mb-2 p-2" placeholder="Search for a location" />
        <ul v-if="suggestions.length" class="autocomplete-dropdown">
            <li v-for="(suggestion, index) in suggestions" :key="index" @click="selectAddress(suggestion)"
                class="autocomplete-item">
                {{ suggestion.display_name }}
            </li>
        </ul>
        <div id="map" ref="mapContainer" style="height: 500px; width: 100%;"></div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";

// Props and Emits
const props = defineProps({
    modelValue: {
        type: Object,
        required: true, // Expecting an object with { address, lat, lng }
    },
});

const emit = defineEmits(["update:modelValue"]);

// Map and location-related refs
const mapContainer = ref(null);
const map = ref(null);
const locationMarker = ref(null);

// Internal state
const searchQuery = ref(props.modelValue.address || "");
const suggestions = ref([]);
const debounceTimeout = ref(null);

const initializeMap = () => {
    if (mapContainer.value) {
        const { lat, lng } = props.modelValue || { lat: 3.139, lng: 101.6869 };
        map.value = L.map(mapContainer.value).setView([lat, lng], 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; OpenStreetMap contributors",
        }).addTo(map.value);

        // Add initial marker
        locationMarker.value = L.marker([lat, lng]).addTo(map.value);
    }
};

const fetchAddressSuggestions = async () => {
    if (!searchQuery.value.trim()) {
        suggestions.value = [];
        return;
    }

    if (debounceTimeout.value) clearTimeout(debounceTimeout.value);

    debounceTimeout.value = setTimeout(async () => {
        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(
            searchQuery.value
        )}&format=json&addressdetails=1&limit=5`;
        try {
            const response = await fetch(url);
            const data = await response.json();
            suggestions.value = data;
        } catch (error) {
            console.error("Error fetching address suggestions:", error);
        }
    }, 300); // Debounce API calls
};

const selectAddress = (address) => {
    searchQuery.value = address.display_name;
    suggestions.value = [];
    setMapLocation(address.lat, address.lon);

    // Emit the selected address and coordinates
    emit("update:modelValue", {
        address: address.display_name,
        lat: parseFloat(address.lat),
        lng: parseFloat(address.lon),
    });
};

const setMapLocation = (lat, lng) => {
    if (!map.value) return;

    // Update the marker on the map
    if (locationMarker.value) {
        locationMarker.value.setLatLng([lat, lng]);
    } else {
        locationMarker.value = L.marker([lat, lng]).addTo(map.value);
    }

    // Pan the map to the new location
    map.value.setView([lat, lng], 13);
};

// Watch for external changes to modelValue
watch(
    () => props.modelValue,
    (newValue) => {
        if (newValue) {
            searchQuery.value = newValue.address || "";
            setMapLocation(newValue.lat, newValue.lng);
        }
    },
    { deep: true }
);

onMounted(() => {
    initializeMap();
});
</script>

<style scoped>
.autocomplete-dropdown {
    background: white;
    border: 1px solid #ccc;
    list-style: none;
    max-height: 150px;
    overflow-y: auto;
    padding: 0;
    margin: 0;
    position: absolute;
    width: 100%;
    z-index: 1000;
}

.autocomplete-item {
    padding: 8px 12px;
    cursor: pointer;
}

.autocomplete-item:hover {
    background-color: #f0f0f0;
}
</style>