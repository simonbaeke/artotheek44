<template>
    <app-main>
        <template slot="title">Leden</template>
        <template slot="content">
            <router-view></router-view>
        </template>
    </app-main>
</template>

<script>
    import appMain from '../basis/main'
    import User from '../../../store/orm/User'
    import Artwork from "../../../store/orm/Artwork";

    export default {
        name: "User",

        components: {
            appMain
        }, methods: {

        },
        mounted() {
            //load artworks

          //  Artwork.dispatch('fetchArtworks')
        }

    }
</script>

<style scoped>

</style>
