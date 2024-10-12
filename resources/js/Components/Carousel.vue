<script setup>
import { faChevronCircleLeft, faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

</script>

<template>
    <div class="flex items-center justify-center">
        <FontAwesomeIcon class="text-4xl pt-8" :style="{ color: 'black' }" :icon="faChevronLeft" />

        <div name="carousel" class="px-20 py-12">
            <div name="carouselFilter" class="flex  mb-4">
                <div class="mr-4">
                    <button type="button"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        This Week
                    </button>
                </div>

                <div class="mr-4">
                    <button type="button"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-none focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-blue-500 dark:hover:border-blue-600 dark:focus:text-blue-500 dark:focus:border-blue-600">
                        This Month
                    </button>
                </div>


                <button type="button"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:outline-none focus:border-blue-600 focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-blue-500 dark:hover:border-blue-600 dark:focus:text-blue-500 dark:focus:border-blue-600">
                    Coming Soon
                </button>
            </div>

            <div name="carouselBody" class="flex items-center">
                <div class="relative w-64 h-92 bg-black border shadow-sm rounded-xl mr-8">
                    <img class="rounded-xl" src="/images/atas.jpeg" alt="Card Image">
                </div>
                <div class="relative w-64 h-92 bg-black border shadow-sm rounded-xl mr-8">
                    <img class="rounded-xl" src="/images/atas.jpeg" alt="Card Image">
                </div>
                <div class="relative w-64 h-92 bg-black border shadow-sm rounded-xl mr-8">
                    <img class="rounded-xl" src="/images/atas.jpeg" alt="Card Image">
                </div>
                <div class="relative w-64 h-92 bg-black border shadow-sm rounded-xl ">
                    <img class="rounded-xl" src="/images/atas.jpeg" alt="Card Image">
                </div>
            </div>
        </div>
        <FontAwesomeIcon class="text-4xl pt-8" :style="{ color: 'black' }" :icon="faChevronRight" />
    </div>

</template>