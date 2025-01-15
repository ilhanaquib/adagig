<template>
    <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "dotsItemClasses": "hs-carousel-active:bg-white hs-carousel-active:border-white size-3 border border-gray-400 rounded-full cursor-pointer"
}' class="relative">
        <div class="hs-carousel relative overflow-hidden w-full min-h-96">
            <div
                class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                <div v-for="(event, index) in events" :key="index"
                    class="hs-carousel-slide relative flex h-full p-6 overflow-hidden">
                    <!-- image -->
                    <div class="absolute inset-0" :style="{
                        backgroundImage: 'url(' + event.poster + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center center',
                        filter: 'blur(8px)'
                    }"></div>
                    <div class="absolute inset-0 bg-black opacity-50"></div>

                    <!-- info -->
                    <div class="flex  relative">
                        <img :src="event.poster" alt="" class="rounded-lg w-1/2 max-w-[200px] h-auto ml-64 mr-28" />
                        <div class="flex flex-col">
                            <span class="mt-12 mb-8 text-6xl font-bold text-white transition duration-700 z-10">{{
                                event.name }}</span>
                            <span class="text-2xl text-white transition duration-700 z-10">{{ event.description
                                }}</span>
                            <span class="text-xl text-white transition duration-700 z-10">{{ formatDate(event.date)
                                }}</span>
                            <button type="button"
                                class="mt-8 py-3 px-4 inline-flex align-center justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-transparent text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                style="background-color: #719192; color: white; width: 150px;">
                                Buy Tickets
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="button"
            class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
            </span>
            <span class="sr-only">Previous</span>
        </button>
        <button type="button"
            class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg"
            style="z-index: 20;">
            <span class="sr-only">Next</span>
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </span>
        </button>

        <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2"></div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import moment from 'moment';
const props = defineProps({
    events: Array
});
const formatDate = (date) => {
    return moment(date).format('MMMM Do YYYY, h:mm:ss a'); // Format as needed
};

</script>

<!-- for the header, make it so that the background is zoomed of the original image, add blur and dark opacity layer.
put the original poster on top of it along with the name descript and other infos. refer to bandsintown show page -->