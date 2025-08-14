<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    events: Array
});

const events = ref(props.events);

const currentIndex = ref(0);

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % events.length;
};

const prevSlide = () => {
    currentIndex.value = (currentIndex.value - 1 + events.length) % events.length;
};

const goToSlide = (index) => {
    currentIndex.value = index;
};

const otherEvents = [
    { title: 'Indie Night', date: 'Sep 20', venue: 'Indie Hall', image: '/images/poster3.png' },
    { title: 'Rock Fest', date: 'Oct 5', venue: 'Rock Arena', image: '/images/poster4.png' },
    { title: 'Pop Vibes', date: 'Oct 15', venue: 'City Stadium', image: '/images/poster5.png' },
    { title: 'EDM Blast', date: 'Nov 1', venue: 'Beachside', image: '/images/poster6.png' },
    { title: 'Acoustic Evening', date: 'Nov 10', venue: 'Cozy Cafe', image: '/images/poster7.png' },
    { title: 'Hip Hop Jam', date: 'Nov 20', venue: 'Urban Stage', image: '/images/poster8.png' }
];

const visibleCount = 5;
const otherCarouselIndex = ref(0);

const nextOtherCarousel = () => {
    if (otherCarouselIndex.value < otherEvents.length - visibleCount) {
        otherCarouselIndex.value++;
    }
};

const prevOtherCarousel = () => {
    if (otherCarouselIndex.value > 0) {
        otherCarouselIndex.value--;
    }
};

const startX = ref(null);

const onTouchStart = (e) => {
    startX.value = e.touches[0].clientX;
};

const onTouchEnd = (e) => {
    if (startX.value === null) return;
    const endX = e.changedTouches[0].clientX;
    const deltaX = endX - startX.value;

    if (Math.abs(deltaX) > 50) {
        if (deltaX > 0) {
            // swipe right -> prev slide
            prevSlide();
        } else {
            // swipe left -> next slide
            nextSlide();
        }
    }
    startX.value = null;
};
</script>

<template>

    <Head title="Home" />
    <Navbar />

    <!-- Events  -->
    <div class="w-full bg-center bg-cover relative overflow-hidden flex" :style="{
        backgroundImage: `url(${events[currentIndex].image})`,
        height: 'calc(100vh - 48px)'
    }" @touchstart="onTouchStart" @touchend="onTouchEnd">
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-black/40 to-black/80 pointer-events-none"></div>

        <div class="relative z-10 flex justify-between w-full px-4 sm:px-8 md:px-16 mb-32">
            <div class="flex flex-col justify-center text-white max-w-xl space-y-4">
                <h1 class="text-3xl text-light md:text-5xl font-bold">
                    {{ events[currentIndex].title }}
                </h1>
                <p class="text-lg text-light font-semibold">
                    {{ new Date(events[currentIndex].date).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'long', year: 'numeric'
                    }) }} • {{ events[currentIndex].location }}
                </p>

                <div class="flex space-x-3 font-bold text-xl">
                    <a :href="events[currentIndex].ticket_url" target="_blank"
                        class="bg-secondary text-primary px-3 py-1.5 rounded transition ">Get
                        Tickets</a>
                    <Link :href="`/events/${events[currentIndex].id}`"
                        class="bg-primary text-secondary px-3 py-1.5 rounded transition ">
                    More Details</Link>
                </div>

                <div class="flex md:hidden space-x-2">
                    <button v-for="(event, index) in events" :key="index" @click="goToSlide(index)"
                        class="w-3 h-3 rounded-full"
                        :class="currentIndex === index ? 'bg-primary' : 'bg-accent'"></button>
                </div>
            </div>

            <div class="hidden md:flex pt-80 flex flex-col items-center space-y-2">
                <!-- Prev/Next Buttons: hidden on mobile and tablet -->
                <div class="hidden md:flex items-center space-x-4">
                    <button @click="prevSlide"
                        class="w-8 h-8 flex items-center justify-center bg-primary hover:bg-secondary text-secondary hover:text-primary rounded-full">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button @click="nextSlide"
                        class="w-8 h-8 flex items-center justify-center bg-primary hover:bg-secondary text-secondary hover:text-primary rounded-full">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>

                <!-- Paginator -->
                <div class="hidden md:flex space-x-2">
                    <button v-for="(event, index) in events" :key="index" @click="goToSlide(index)"
                        class="w-3 h-3 rounded-full"
                        :class="currentIndex === index ? 'bg-primary' : 'bg-accent'"></button>
                </div>
            </div>
        </div>

        <!-- BOTTOM TRANSPARENT CAROUSEL -->
        <div class="absolute bottom-0 left-0 w-full px-4 sm:px-6 pb-4 z-20">
            <!-- Filters -->
            <div class="flex justify-between items-center mb-2">
                <div class="flex space-x-2 text-lg">
                    <button class="px-2 py-1 text-white rounded  transition">
                        This Month
                    </button>
                    <button class="px-2 py-1 text-white rounded transition">
                        This Week
                    </button>
                    <button class="px-2 py-1 text-white rounded  transition">
                        Coming Soon
                    </button>
                </div>
                <Link href="/events" class="text-white hover:underline text-xs sm:text-sm">More →</Link>
            </div>

            <!-- Desktop Carousel: hidden on mobile/tablet -->
            <div class="relative hidden md:block">
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500"
                        :style="{ transform: `translateX(-${otherCarouselIndex * (100 / visibleCount)}%)` }">
                        <div v-for="(event, index) in events" :key="index" class="min-w-[20%] px-1.5">
                            <Link :href="`/events/${events[currentIndex].id}`">
                            <div
                                class="bg-primary p-2 rounded-lg text-secondary hover:bg-secondary hover:text-light transition">
                                <img :src="event.image" alt="" class="w-full h-52 object-cover rounded mb-1.5" />
                                <h3 class="text-xs font-bold truncate ">{{ event.title }}</h3>
                                <p class="text-[10px] truncate">{{ event.date }} • {{ event.location }}</p>
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Prev/Next Buttons: hidden on mobile/tablet -->
                <button @click="prevOtherCarousel"
                    class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>
                <button @click="nextOtherCarousel"
                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full w-7 h-7 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>

            <!-- Mobile/Tablet Grid: hidden on desktop -->
            <div class="grid grid-cols-4 gap-2 md:hidden mt-2">
                <div v-for="(event, index) in events.slice(0, 16)" :key="'grid-' + index"
                    class="bg-primary p-2 rounded-lg text-light hover:bg-secondary transition">
                    <Link :href="`/events/${events[currentIndex].id}`">

                    <img :src="event.image" alt="" class="w-full h-16 object-cover rounded mb-1" />
                    <h3 class="text-xs font-bold truncate">{{ event.title }}</h3>
                    <p class="text-[9px] truncate">{{ event.date }} • {{ event.venue }}</p>
                    </Link>
                </div>
            </div>
        </div>
    </div>

    <!-- Musics -->

    <!-- Artists -->
</template>
