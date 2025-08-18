<script setup>
import Navbar from '@/AdagigComponents/Navbar.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

// Radio selection: Band or Organisation
const selectedCategory = ref('Band')

const form = useForm({
    category: selectedCategory.value,
    name: '',
    genre: '',
    description: '',
    location: '',
    links: '',
    logo: null,
    logoPreview: null,
    wallpaper: null,
    wallpaperPreview: null,
    users: [] // store full user objects for display
})

watch(selectedCategory, (val) => {
    form.category = val
})

// Files
function handleFileChange(event, kind) {
    const file = event.target.files[0]
    if (!file) return
    if (kind === 'logo') {
        form.logo = file
        form.logoPreview = URL.createObjectURL(file)
    } else if (kind === 'wallpaper') {
        form.wallpaper = file
        form.wallpaperPreview = URL.createObjectURL(file)
    }
}
function handleDrop(event, kind) {
    event.preventDefault()
    const file = event.dataTransfer.files[0]
    if (file) handleFileChange({ target: { files: [file] } }, kind)
}

// ---------- User search ----------
const searchQuery = ref('')
const searchResults = ref([])
const searching = ref(false)
let debounceTimer = null
let activeController = null

// safe URL builder (with or without Ziggy)
function makeSearchUrl(q) {
    if (typeof window !== 'undefined' && typeof window.route === 'function') {
        // If your route is named 'api.users.search' and defined as GET /api/users/search
        // Ziggy will add ?q=... automatically for non-path params.
        const url = window.route('api.users.search', { q })
        return url
    }
    return `/api/users/search?q=${encodeURIComponent(q)}`
}

watch(searchQuery, (val) => {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(async () => {
        const q = val.trim()
        // Abort any in-flight request
        if (activeController) activeController.abort()
        activeController = new AbortController()

        if (!q) {
            searchResults.value = []
            return
        }

        try {
            searching.value = true
            const res = await fetch(makeSearchUrl(q), {
                method: 'GET',
                signal: activeController.signal,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            if (!res.ok) throw new Error(`Search failed: ${res.status}`)
            const data = await res.json()
            // Accept either a raw array or { users: [...] }
            const list = Array.isArray(data) ? data : (Array.isArray(data.users) ? data.users : [])
            searchResults.value = list
        } catch (e) {
            if (e.name !== 'AbortError') console.error(e)
            searchResults.value = []
        } finally {
            searching.value = false
        }
    }, 250)
})

function escapeRegExp(s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') }
function highlight(text, q) {
    const s = q.trim()
    if (!s) return text
    const re = new RegExp(`^(${escapeRegExp(s)})`, 'i') // prefix first
    if (re.test(text)) return text.replace(re, '<strong>$1</strong>')
    const reWord = new RegExp(`(\\b${escapeRegExp(s)})`, 'i') // then word-boundary
    return text.replace(reWord, '<strong>$1</strong>')
}

function addUser(user) {
    if (!form.users.find(u => u.id === user.id)) {
        form.users.push(user) // keep full object for nice chips
    }
    searchQuery.value = ''
    searchResults.value = []
}

function removeUser(userId) {
    form.users = form.users.filter(u => u.id !== userId)
}

// Submit (send IDs only)
function submit() {
    form.name = form.name.trim()
    form.description = form.description.trim()
    form.genre = form.genre.trim()
    form.location = form.location.trim()
    form.links = form.links.trim()

    form.transform(data => ({
        ...data,
        users: data.users.map(u => u.id) // IDs only for backend
    })).post(route('group.store'), {
        onFinish: () => {
            // reset transform so form state remains as objects in the UI
            form.transform((d) => d)
        }
    })
}
</script>

<template>

    <Head title="Create Group" />
    <Navbar />

    <div class="flex flex-col items-center min-h-screen pt-4 space-y-6 px-4 sm:px-6 lg:px-0">
        <h1 class="font-bold text-xl text-center">Create a new group!</h1>

        <!-- Category Selection -->
        <div class="flex flex-wrap justify-center gap-4">
            <label v-for="option in ['Band', 'Organisation']" :key="option"
                class="inline-flex items-center cursor-pointer">
                <input type="radio" :value="option" v-model="selectedCategory" name="category"
                    class="form-radio text-primary focus:ring-primary border-primary" />
                <span class="ml-2">{{ option }}</span>
            </label>
        </div>

        <div class="mt-6 w-full max-w-4xl">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="flex flex-col md:flex-row md:space-x-6 items-start space-y-4 md:space-y-0 md:px-20">
                    <!-- Logo Upload -->
                    <div class="w-full md:w-64 h-48 border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer shadow-md hover:shadow-lg transition"
                        @dragover.prevent @drop.prevent="handleDrop($event, 'logo')">
                        <input type="file" accept="image/*" @change="e => handleFileChange(e, 'logo')" class="hidden"
                            id="logoUpload" />
                        <label for="logoUpload" class="cursor-pointer text-sm text-gray-500 text-center">
                            Upload Logo (drag & drop or click)
                        </label>

                        <div v-if="form.logoPreview" class="mt-4 w-full">
                            <img :src="form.logoPreview" alt="Logo Preview"
                                class="w-full h-32 object-cover rounded-lg shadow-md" />
                        </div>
                    </div>

                    <!-- Wallpaper Upload -->
                    <div class="w-full md:w-64 h-48 border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer shadow-md hover:shadow-lg transition"
                        @dragover.prevent @drop.prevent="handleDrop($event, 'wallpaper')">
                        <input type="file" accept="image/*" @change="e => handleFileChange(e, 'wallpaper')"
                            class="hidden" id="wallpaperUpload" />
                        <label for="wallpaperUpload" class="cursor-pointer text-sm text-gray-500 text-center">
                            Upload Wallpaper (drag & drop or click)
                        </label>

                        <div v-if="form.wallpaperPreview" class="mt-4 w-full">
                            <img :src="form.wallpaperPreview" alt="Wallpaper Preview"
                                class="w-full h-32 object-cover rounded-lg shadow-md" />
                        </div>
                    </div>
                </div>

                <!-- Text Fields -->
                <div class="space-y-4 md:px-20">
                    <div>
                        <label class="block mb-2 font-semibold">Name</label>
                        <input v-model="form.name" type="text" placeholder="Enter name"
                            class="w-full border rounded px-3 py-2" />
                    </div>

                    <div v-if="selectedCategory === 'Band'">
                        <label class="block mb-2 font-semibold">Genre</label>
                        <input v-model="form.genre" type="text" placeholder="Enter genre"
                            class="w-full border rounded px-3 py-2" />
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Description</label>
                        <textarea v-model="form.description" placeholder="Enter description" rows="4"
                            class="w-full border rounded px-3 py-2 resize-y"></textarea>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Location</label>
                        <input v-model="form.location" type="text" placeholder="Enter location"
                            class="w-full border rounded px-3 py-2" />
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Links</label>
                        <input v-model="form.links" type="url" placeholder="Enter links (website, socials)"
                            class="w-full border rounded px-3 py-2" />
                    </div>
                </div>

                <!-- User Search -->
                <div class="relative md:px-20">
                    <label class="block mb-2 font-semibold">Add Members</label>
                    <input v-model="searchQuery" type="text" placeholder="Search for users…"
                        class="w-full border rounded px-3 py-2" autocomplete="off" />

                    <!-- Dropdown -->
                    <div v-if="searchQuery && (searchResults.length || searching)"
                        class="absolute z-10 mt-1 w-full bg-white border rounded shadow-md max-h-56 overflow-y-auto">
                        <div v-if="searching" class="px-3 py-2 text-gray-500">Loading…</div>
                        <template v-else>
                            <button v-for="user in searchResults" :key="user.id" type="button" @click="addUser(user)"
                                class="w-full text-left px-3 py-2 hover:bg-gray-100">
                                <span v-html="highlight(user.username, searchQuery)"></span>
                            </button>
                            <div v-if="!searchResults.length" class="px-3 py-2 text-gray-500">No matches</div>
                        </template>
                    </div>
                </div>

                <!-- Selected Users -->
                <div v-if="form.users.length" class="flex flex-wrap gap-2 mt-2 md:px-20">
                    <span v-for="user in form.users" :key="user.id"
                        class="px-3 py-1 bg-primary text-secondary rounded-full flex items-center">
                        {{ user.username }}
                        <button type="button" @click="removeUser(user.id)" class="ml-2 text-sm">✕</button>
                    </span>
                </div>



                <!-- Submit Button -->
                <div class="flex justify-center mt-6 md:px-44">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-primary text-secondary rounded hover:bg-secondary hover:text-primary transition disabled:opacity-50"
                        :disabled="form.processing || !selectedCategory">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
