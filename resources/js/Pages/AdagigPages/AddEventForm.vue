<template>

    <Head title="Add Event" />

    <MasterLayout>
        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5">
            <form @submit.prevent="submit">
                <h1 class="text-2xl font-bold">Add an Event</h1>
                <div class="flex pt-4 items-start align-start">
                    <div class="justify-center flex flex-col w-80 h-96 mr-12 bg-white border border-gray-200 shadow-sm rounded-xl "
                        @click="triggerFileInput" @dragover.prevent="handleDragOver" @drop.prevent="handleFileDrop">
                        <img v-if="posterPreview" :src="posterPreview" alt="Poster Preview"
                            class="object-cover w-full h-full rounded-xl" />

                        <span v-else class="text-gray-500 font-medium ml-4">Click or drag image here to upload
                            poster</span>

                        <input id="poster" type="file" accept="image/*" class="hidden" ref="fileInput"
                            @change="handleImageUpload" />
                    </div>

                    <div class="flex flex-col w-full bg-white border border-gray-200 shadow-sm rounded-xl p-4 md:p-5">
                        <label for="event_name">Event Name: </label>
                        <input id="event_name" v-model="form.name" class="border rounded-md w-full mb-4 p-2" />

                        <!-- make this popup -->
                        <label for="date">Date:</label>
                        <VueDatePicker v-model="form.date" :format="format" />

                        <!-- <label for="location">Location:</label> -->
                        <Map v-model="form.location" />

                        <label for="description">Description:</label>
                        <input id="description" v-model="form.description" class="border rounded-md w-full mb-4 p-2" />

                        <label for="link_to_post">Link to Post:</label>
                        <input id="link_to_post" v-model="form.link_to_post"
                            class="border rounded-md w-full mb-4 p-2" />

                        <label for="link_to_ticket">Link to Ticket:</label>
                        <input id="link_to_ticket" v-model="form.link_to_ticket"
                            class="border rounded-md w-full mb-4 p-2" />
                    </div>
                </div>
                <button type="submit" style="background-color: #719192;"
                    class="text-white rounded-md px-4 py-2 hover:bg-blue-600">
                    Submit
                </button>
            </form>
        </div>

    </MasterLayout>

</template>

<script setup>
import MasterLayout from '@/Layouts/MasterLayout.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3';
import Map from '@/Components/AdagigComponents/Map.vue';
const date = ref(new Date());

const form = reactive({
    name: null,
    poster: null,
    date: null,
    location: {
        address: "",
        lat: 3.139,
        lng: 101.6869,
    },
    description: null,
    link_to_post: null,
    link_to_ticket: null,
})

// In case of a range picker, you'll receive [Date, Date]
const format = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `Selected date is ${day}/${month}/${year}`;
}

const fileInput = ref(null);
const posterPreview = ref(null);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        createImagePreview(file);
        form.poster = file; // Save the file in the form
    }
};

const handleFileDrop = (event) => {
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        createImagePreview(file);
        form.poster = file; // Save the file in the form
    }
};

const handleDragOver = (event) => {
    // Optional: Add custom logic or styling when the drag event occurs
};

const createImagePreview = (file) => {
    const reader = new FileReader();
    reader.onload = (e) => {
        posterPreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
};

function submit() {

    const day = form.date.get

    const formData = new FormData();
    formData.append("name", form.name);
    formData.append("poster", form.poster);
    formData.append("date", form.date);
    formData.append("location[address]", form.location.address);
    formData.append("location[lat]", form.location.lat);
    formData.append("location[lng]", form.location.lng);
    formData.append("description", form.description);
    formData.append("link_to_post", form.link_to_post);
    formData.append("link_to_ticket", form.link_to_ticket);

    console.log(form.date);

    router.post('/submit-event', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    });
}

</script>