<script setup>
import { ref, computed, onMounted, reactive, onBeforeUnmount } from 'vue';


const props = defineProps({
    events: Array
});

const scrollPosition = ref(0);
const itemWidth = ref(0);
const containerWidth = ref(0);
const maxScrollPosition = ref(0);

// Method to calculate sizes
const calculateSizes = () => {
    const carouselItem = document.querySelector('[name="carousel-item"]');
    if (carouselItem) {
        itemWidth.value = carouselItem.offsetWidth + 16; // Add 16px for padding
        const carouselContainer = document.querySelector('[name="carousel"]');
        if (carouselContainer) {
            containerWidth.value = carouselContainer.offsetWidth;
            maxScrollPosition.value = itemWidth.value * props.events.length - containerWidth.value;
        }
    }
};

// Methods to navigate carousel
const nextSlide = () => {
    scrollPosition.value = Math.min(scrollPosition.value + itemWidth.value, maxScrollPosition.value);
};

const prevSlide = () => {
    scrollPosition.value = Math.max(scrollPosition.value - itemWidth.value, 0);
};

// Lifecycle hooks
onMounted(() => {
    calculateSizes();
    window.addEventListener('resize', calculateSizes);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', calculateSizes);
});
const hover = ref(false);
</script>

<template>
    <div class="relative">
        <div name="carousel" class="flex overflow-x-hidden transition-transform duration-500"
            :style="{ transform: `translateX(-${scrollPosition}px)` }">
            <div name="carousel-item" v-for="(event, index) in events" :key="index"
                class="flex-shrink-0 w-1/4 px-8 py-8" :style="{ width: `${itemWidth}px` }" 
                >
                <img :src="event.image" alt="carousel_image" class="w-full h-auto" />
            </div>
        </div>

        <button class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white p-2 rounded-full" @click="prevSlide">
            &#10094;
        </button>
        <button class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white p-2 rounded-full"
            @click="nextSlide">
            &#10095;
        </button>
        <!-- <div name="carousel" class="px-20 pt-12 pb-28" @mouseover="hover = true" @mouseleave="hover = false">
            <div name="carouselFilter" class="flex mb-4">
                <div class="mr-4">
                    <button type="button"
                        class="py-3 px-4 inline -flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        This Week
                    </button>
                </div>
                <div class="mr-4">
                    <button type="button"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-none focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                        This Month
                    </button>
                </div>
                <button type="button"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-none focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                    Coming Soon
                </button>
            </div>
            <div class="carousel-container">
                <div class="carousel-wrapper" :style="carouselStyle">
                    <div v-for="(event, index) in events" :key="index" class="carousel-item">
                        <img :src="event.image" alt="carousel image" />
                        <div>
                            {{ event.name }}
                        </div>
                        <dir>{{ index }}</dir>
                    </div>
                </div>

                <div v-if="hover">
                    <button class="prev" @click="prev">‹</button>
                    <button class="next" @click="next">›</button>
                </div>
            </div>
        </div> -->
    </div>
</template>

<style scoped>
/* Custom styles for smooth horizontal scrolling */
.carousel-container {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.carousel-item {
    min-width: 100%;
}
</style>