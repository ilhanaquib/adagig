<script setup>
// Import ref from Vue
import { ref, Transition } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faCircleInfo, faClose, faHouse } from '@fortawesome/free-solid-svg-icons';
import { faCalendar, faUser } from '@fortawesome/free-regular-svg-icons';

const isOpen = ref(false);

const toggleSidebar = () => {
    isOpen.value = !isOpen.value;
};

defineExpose({
    toggleSidebar,
    isOpen,
});
</script>

<template>
    <Transition name="slide">
        <div v-if="isOpen" id="hs-offcanvas-example"
            class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-800 dark:border-neutral-700"
            role="dialog" tabindex="-1" aria-label="Sidebar">

            <div class="px-6 flex items-end">
                <div class="flex items-end">
                    <img src="/images/anjing.png" alt="logo" class="h-8 w-auto px-4">
                    <a class="flex-none font-semibold text-xl text-black focus:outline-none focus:opacity-80 dark:text-white"
                        href="#" aria-label="Brand">Adagig</a>
                </div>

                <button type="button" class="ml-auto" @click="toggleSidebar">
                    <FontAwesomeIcon :style="{ color: 'black' }" :icon="faClose" />
                </button>
            </div>
            <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="space-y-1.5">
                    <li>
                        <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:bg-neutral-700 dark:text-white"
                            href="#">
                            <FontAwesomeIcon :style="{ color: 'black' }" :icon="faHouse" />
                            Home
                        </a>
                        <a href="#"
                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-400 dark:hs-accordion-active:text-white dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                            aria-expanded="true" aria-controls="users-accordion">
                            <FontAwesomeIcon :style="{ color: 'black' }" :icon="faUser" />
                            Account
                        </a>
                        <a href="#"
                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-400 dark:hs-accordion-active:text-white dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                            aria-expanded="true" aria-controls="users-accordion">
                            <FontAwesomeIcon :style="{ color: 'black' }" :icon="faCalendar" />
                            Events
                        </a>
                        <a href="#"
                            class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-400 dark:hs-accordion-active:text-white dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                            aria-expanded="true" aria-controls="users-accordion">
                            <FontAwesomeIcon :style="{ color: 'black' }" :icon="faCircleInfo" />
                            About Us
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </Transition>
</template>



<style scoped>
/* The sliding-div class can be used to style the div */
.sliding-div {
    width: 200px;
    height: 100px;
    background-color: #4caf50;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}

/* Transition for sliding from the left */
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.5s ease;
}

/* Initial state when the element is entering (from the left) */
.slide-enter-from {
    transform: translateX(-100%);
}

/* Final state when the element is leaving (to the left) */
.slide-leave-to {
    transform: translateX(-100%);
}
</style>