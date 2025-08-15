<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
    first_name: '',
    last_name: '',
    username: '',
    bio: '',
    location: '',
    link: '',
    profile_picture: null,
    wallpaper: null,
})

const profilePicturePreview = ref(null);
const wallpaperPreview = ref(null);

function handleFileChange(event, type) {
    const file = event.target.files[0]
    if (!file) return

    if (type === 'profile_picture') {
        form.profile_picture = file
        profilePicturePreview.value = URL.createObjectURL(file)
    } else if (type === 'wallpaper') {
        form.wallpaper = file
        wallpaperPreview.value = URL.createObjectURL(file)
    }
}

function handleDrop(event, type) {
    const file = event.dataTransfer.files[0]
    if (!file) return
    handleFileChange({ target: { files: [file] } }, type)
}

function submitForm() {
    form.post(route('profile.update'), {
        preserveScroll: true,
        forceFormData: true,
        headers: {
            'X-HTTP-Method-Override': 'PATCH',
        },
    });
}
</script>

<template>
    <form @submit.prevent="submitForm" class="max-h-[70vh] overflow-y-auto space-y-6 p-4">
        <h1>Edit your profile here!</h1>
        <!-- Profile Picture Upload -->
        <div class="w-32 h-32 mx-auto border-2 border-dashed border-gray-300 rounded-full p-2 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg transition"
            @dragover.prevent @drop.prevent="handleDrop($event, 'profile_picture')">
            <input type="file" accept="image/*" @change="e => handleFileChange(e, 'profile_picture')" class="hidden"
                id="profilePictureUpload" />
            <label for="profilePictureUpload" class="cursor-pointer text-sm text-gray-500 text-center">
                Click or drag to upload profile picture
            </label>

            <div v-if="profilePicturePreview" class="absolute w-32 h-32 rounded-full overflow-hidden">
                <img :src="profilePicturePreview" alt="Profile Preview" class="w-full h-full object-cover" />
            </div>
        </div>
        <p v-if="form.errors.profile_picture" class="text-red-500">
            {{ form.errors.profile_picture }}
        </p>

        <!-- Wallpaper Upload -->
        <div class="w-full h-48 border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer shadow-md hover:shadow-lg transition"
            @dragover.prevent @drop.prevent="handleDrop($event, 'wallpaper')">
            <input type="file" accept="image/*" @change="e => handleFileChange(e, 'wallpaper')" class="hidden"
                id="wallpaperUpload" />
            <label for="wallpaperUpload" class="cursor-pointer text-sm text-gray-500 text-center">
                Click or drag to upload wallpaper
            </label>

            <div v-if="wallpaperPreview" class="mt-2 w-full h-full overflow-hidden rounded-lg">
                <img :src="wallpaperPreview" alt="Wallpaper Preview" class="w-full h-full object-cover" />
            </div>
        </div>

        <!-- Text Inputs -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input v-model="form.first_name" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Last Name <span class="text-gray-400 text-xs">(optional)</span>
                </label>
                <input v-model="form.last_name" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username (@)</label>
                <input v-model="form.username" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea v-model="form.bio" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <input v-model="form.location" type="text"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Link</label>
                <input v-model="form.link" type="url"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full bg-primary text-secondary font-bold py-2 px-4 rounded hover:bg-secondary hover:text-primary transition"
                :disabled="form.processing">
                Save Changes
            </button>
        </div>
    </form>
</template>
