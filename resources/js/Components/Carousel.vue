<script setup>
import { ref, computed, onMounted, reactive } from 'vue';
import { faChevronLeft, faChevronRight, faCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    events: Array
});

const currentIndex = ref(0)

const visibleItems = 3

const prev = () => {
    if (currentIndex.value === 0) {
        currentIndex.value = props.events.length - visibleItems
    } else {
        currentIndex.value -= 1
    }
}

const next = () => {
    if (currentIndex.value === props.events.length - visibleItems) {
        currentIndex.value = 0
    } else {
        currentIndex.value += 1
    }
}

const carouselStyle = computed(() => ({
    transform: `translateX(-${currentIndex.value * (100 / visibleItems)}%)`,
    transition: 'transform 0.5s ease-in-out'
}))

const hover = ref(false);
</script>

<template>
    <div class="flex items-center justify-center">
        <div name="carousel" class="px-20 pt-12 pb-28" @mouseover="hover = true" @mouseleave="hover = false">
            <!-- <div name="carouselFilter" class="flex mb-4">
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
            </div> -->
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
        </div>
    </div>
</template>

<style scoped>
.carousel-container {
    position: relative;
    overflow: hidden;
    margin: 0 auto;
}

.carousel-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.carousel-item {
    min-width: calc(20% - 0.5px);
    box-sizing: border-box;
}

.carousel-item img {
    width: 100%;
    display: block;
    border-radius: 5px;
}

button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}

button.prev {
    left: 10px;
}

button.next {
    right: 10px;
}

button:focus {
    outline: none;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.6) 100%);
    display: flex;
    align-items: flex-end;
    /* Align text at the bottom */
    justify-content: center;
    /* Center the text horizontally */
    padding: 10px;
    color: white;
    /* Text color */
    font-size: 18px;
    /* Text size */
    text-align: center;
    border-radius: 5px;
    /* Match border-radius of the image */
    opacity: 1;
    /* Set initial opacity */
    transition: opacity 0.3s ease;
}

/* Optional: Fade the overlay on hover */
.carousel-item:hover .overlay {
    opacity: 1;
    /* Increase the opacity on hover */
}

.overlay-text {
    margin: 0;
    padding: 10px;
    font-size: 1.2em;
}
</style>