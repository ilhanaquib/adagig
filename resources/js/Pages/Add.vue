<!-- TODO: add music and merch and other categories later -->
<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const selectedCategory = ref('Post');

const form = useForm({
    category: '',
    // Post
    postTitle: '',
    postImage: null,
    postImagePreview: null,
    // Event
    eventName: '',
    eventDescription: '',
    eventLocation: '',
    eventDate: '',
    eventTime: '',
    eventTicketUrl: '',
    eventTicketPrice: '',
    eventImage: null,
    eventImagePreview: null,
});

// Keep category synced
watch(selectedCategory, (val) => {
    form.category = val;
});

// Handle file change for both drag & drop or file input
function handleFileChange(event, type) {
    const file = event.target.files[0];
    if (file) {
        if (type === 'post') {
            form.postImage = file;
            form.postImagePreview = URL.createObjectURL(file);
        } else if (type === 'event') {
            form.eventImage = file;
            form.eventImagePreview = URL.createObjectURL(file);
        }
    }
}

// Drag & drop handler
function handleDrop(event, type) {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (file) handleFileChange({ target: { files: [file] } }, type);
}

function submit() {
    // Trim fields
    form.postTitle = form.postTitle.trim();
    form.eventName = form.eventName.trim();

    // Determine the route
    form.post(route('submit.new'));
}
</script>

<template>

    <Head title="Add something new" />
    <Navbar />
    <div class="flex flex-col items-center min-h-screen pt-4 space-y-6 px-4 sm:px-6 lg:px-0">
        <h1 class="font-bold text-xl text-center">Add something new to Adagig!</h1>

        <!-- Category Selection -->
        <div class="flex flex-wrap justify-center gap-4">
            <label v-for="option in ['Post', 'Event']" :key="option" class="inline-flex items-center cursor-pointer">
                <input type="radio" :value="option" v-model="selectedCategory" name="category"
                    class="form-radio text-primary focus:ring-primary border-primary" />
                <span class="ml-2">{{ option }}</span>
            </label>
        </div>

        <div class="mt-6 w-full max-w-4xl">
            <form @submit.prevent="submit" class="space-y-6">

                <!-- Post -->
                <div v-if="selectedCategory === 'Post'"
                    class="flex flex-col md:flex-row md:space-x-6 items-start justify-center space-y-4 md:space-y-0 md:px-20">

                    <!-- Image Upload -->
                    <div class="w-full md:w-64 h-72 border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer shadow-md hover:shadow-lg transition"
                        @dragover.prevent @drop.prevent="handleDrop($event, 'post')">
                        <input type="file" accept="image/*" @change="e => handleFileChange(e, 'post')" class="hidden"
                            id="postImageUpload" />
                        <label for="postImageUpload" class="cursor-pointer text-sm text-gray-500 text-center">
                            Drag and drop an image here, or click to browse.
                        </label>

                        <div v-if="form.postImagePreview" class="mt-4 w-full">
                            <img :src="form.postImagePreview" alt="Preview"
                                class="w-full h-48 object-cover rounded-lg shadow-md" />
                        </div>
                    </div>



                    <!-- Caption -->
                    <div class="flex flex-col items-center w-full md:w-64">
                        <label class="block mb-2 font-semibold">Write Something!</label>
                        <textarea v-model="form.postTitle" placeholder="Write your caption here..." rows="5"
                            class="w-full border rounded px-3 py-2 resize-y"></textarea>
                    </div>


                </div>


                <!-- Event -->
                <div v-else-if="selectedCategory === 'Event'"
                    class="flex flex-col md:flex-row md:space-x-6 items-start space-y-4 md:space-y-0 md:px-4">

                    <!-- Image Upload -->
                    <div class="w-full md:w-64 h-72 border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer shadow-md hover:shadow-lg transition"
                        @dragover.prevent @drop.prevent="handleDrop($event, 'event')">
                        <input type="file" accept="image/*" @change="e => handleFileChange(e, 'event')" class="hidden"
                            id="eventImageUpload" />
                        <label for="eventImageUpload" class="cursor-pointer text-sm text-gray-500 text-center">
                            Drag and drop an image here, or click to browse.
                        </label>

                        <div v-if="form.eventImagePreview" class="mt-4 w-full">
                            <img :src="form.eventImagePreview" alt="Preview"
                                class="w-full h-48 object-cover rounded-lg shadow-md" />
                        </div>
                    </div>


                    <!-- Event Details -->
                    <div class="flex-1 flex flex-col space-y-4 w-full md:w-auto">
                        <div>
                            <label class="block mb-2 font-semibold">Event Name</label>
                            <input v-model="form.eventName" type="text" placeholder="Enter event name"
                                class="w-full border rounded px-3 py-2" />
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold">Event Description</label>
                            <textarea v-model="form.eventDescription" placeholder="Enter event description" rows="4"
                                class="w-full border rounded px-3 py-2 resize-y"></textarea>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold">Event Location</label>
                            <input v-model="form.eventLocation" type="text" placeholder="Enter event location"
                                class="w-full border rounded px-3 py-2" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 font-semibold">Event Date</label>
                                <input v-model="form.eventDate" type="date" class="w-full border rounded px-3 py-2" />
                            </div>

                            <div>
                                <label class="block mb-2 font-semibold">Event Time</label>
                                <input v-model="form.eventTime" type="time" class="w-full border rounded px-3 py-2" />
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold">Ticket URL</label>
                            <input v-model="form.eventTicketUrl" type="url" placeholder="Enter ticket purchase URL"
                                class="w-full border rounded px-3 py-2" />
                        </div>

                        <div>
                            <label class="block mb-2 font-semibold">Ticket Price</label>
                            <input v-model="form.eventTicketPrice" type="number" min="0" step="0.01"
                                placeholder="Enter ticket price" class="w-full border rounded px-3 py-2" />
                        </div>
                    </div>

                </div>



                <!-- Submit Button -->
                <div class="flex justify-center mt-6 md:px-44">
                    <button type="submit"
                        class="w-full  px-4 py-2 bg-primary text-secondary rounded hover:bg-secondary hover:text-primary transition disabled:opacity-50"
                        :disabled="form.processing || !selectedCategory">
                        Submit
                    </button>
                </div>


            </form>
        </div>
    </div>
</template>
