<template>
    <router-view></router-view>
</template>

<script>
    import Artist from '../../../store/orm/Artist'

    export default {
        name: "Artist"
        ,
        mounted() {
            Artist.dispatch('fetchArtists')
        }
    }
</script>

<style scoped>

</style>
