<template>
    <div class="mt-8 mb-2 mx-8">
        <span class="text-xl">This Week</span>

    </div>

    <!-- Slider -->
    <div data-hs-carousel='{
      "loadingClasses": "opacity-0",
      "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer",
      "slidesQty": {
        "xs": 1,
        "lg": 5
      }
    }' class="relative mx-4">
        <div class="hs-carousel w-full overflow-hidden bg-white">
            <div class="relative h-96 -mx-1">
                <!-- transition-transform duration-700 -->
                <div
                    class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap opacity-0 transition-transform duration-700">
                    <div v-for="(event, index) in events" :key="index" class="hs-carousel-slide flex w-full ml-2">
                        <div class="flex justify-center h-full w-full  dark:bg-neutral-900">
                            <img :src="event.image" alt="" class="w-full object-cover mt-2 mb-2 rounded-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="button"
            class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg">
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
            </span>
            <span class="sr-only">Previous</span>
        </button>
        <button type="button"
            class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg">
            <span class="sr-only">Next</span>
            <span class="text-2xl" aria-hidden="true">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </span>
        </button>

        <!-- <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2"></div> -->
    </div>
    <!-- End Slider -->
</template>

<script setup>
const props = defineProps({
    events: Array
});
</script>