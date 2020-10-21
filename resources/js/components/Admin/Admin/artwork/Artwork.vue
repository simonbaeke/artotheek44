<template>
    <router-view></router-view>
</template>

<script>
    import Artwork from '../../../store/orm/Artwork'
    export default {
        name: "Artwork",
        created(){
            Artwork.dispatch('fetchArtworks',{
                detail:true
            })
        }
    }
</script>

<style scoped>

</style>
