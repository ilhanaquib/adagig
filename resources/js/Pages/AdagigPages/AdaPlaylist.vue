<template>
    <div>
        <h1>Playlist Tracks</h1>
        <ul v-if="playlist?.items?.length">
            <li v-for="(item, index) in playlist.items" :key="index">
                <strong>{{ item.track.name }}</strong> by
                <span v-for="(artist, i) in item.track.artists" :key="i">
                    {{ artist.name }}<span v-if="i < item.track.artists.length - 1">, </span>
                </span>
            </li>
        </ul>
        <p v-else>No tracks found in this playlist.</p>
    </div>
</template>

<script setup>
defineProps({
    playlist: Object,
});
</script>