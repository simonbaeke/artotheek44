<template>
    <tr>
        <router-link tag="td" :to="{ name: 'artistdetail', params: { id: artist.id}}">{{
            artist.firstname }}
        </router-link>
        <router-link tag="td" :to="{ name: 'artistdetail', params: { id: artist.id}}">{{
            artist.lastname }}
        </router-link>
        <router-link tag="td" :to="{ name: 'artistdetail', params: { id: artist.id}}">{{
            artist.short }}
        </router-link>

    </tr>
</template>

<script>
    export default {
        name: "ArtistListRow",
        props: {
            artist: {
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
