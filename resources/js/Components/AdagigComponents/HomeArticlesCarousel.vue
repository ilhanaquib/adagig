<template>
    <div class="mt-8 mx-8 text-xl justify-start font-medium">
        Articles
    </div>

    <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer",
    "slidesQty": {
      "xs": 1,
      "lg": 5
    }
  }' class="relative mx-4" @mouseenter="hover = true" @mouseleave="hover = false">

        <div class="hs-carousel w-full overflow-hidden bg-white">
            <div class="relative h-96 -mx-1">
                <div
                    class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700">
                    <div v-for="(event, index) in events" :key="index" class="hs-carousel-slide flex w-full ml-2"
                        @mouseenter="hoveredEvent = index" @mouseleave="hoveredEvent = null">
                        <Link :href="route('event.show', { id: event.id })"
                            class="relative flex justify-center h-full w-full dark:bg-neutral-900">
                        <img :src="event.poster" alt="" class="w-full object-cover mt-2 mb-2 rounded-lg">
                        <div v-if="hoveredEvent === index"
                            class="absolute bottom-2 inset-0 bg-gradient-to-t from-black to-transparent opacity-70 rounded-lg flex items-end p-4">
                            <div class="flex flex-col">
                                <div class="text-white font-semibold">{{ event.name }}</div>
                                <div class="text-white">{{ event.description }}</div>
                            </div>
                        </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <button v-show="hover" type="button"
            class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute top-1/2 transform -translate-y-1/2 start-2 inline-flex justify-center items-center w-[46px] h-[46px] bg-white text-gray-800 focus:outline-none rounded-full shadow-md">
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="#719192" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
            </span>
            <span class="sr-only">Previous</span>
        </button>

        <button v-show="hover" type="button"
            class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute top-1/2 transform -translate-y-1/2 end-2 inline-flex justify-center items-center w-[46px] h-[46px] bg-white text-gray-800 focus:outline-none rounded-full shadow-md">
            <span class="sr-only">Next</span>
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="#719192" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </span>
        </button>

        <!-- Pagination -->
        <!-- <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2"></div> -->
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