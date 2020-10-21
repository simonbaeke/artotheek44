<template>
    <app-main>
        <template slot="content">
            <component
                    :is="selectedComponent"
                    :artwork="artwork"
                    v-on:cancel="selectedComponent='artworkInfo'"
                    v-on:edit="selectedComponent = 'artworkEdit'"/>

            <v-btn text v-on:click="$router.go(-1)">Terug</v-btn>
        </template>

    </app-main>


</template>

<script>
    import artworkInfo from './ArtworkInfo.vue'
    import Artwork from '../../../store/orm/Artwork'
    import artworkEdit from './ArtworkEdit.vue'
    import appMain from '../basis/main'

    export default {
        name: "ArtworkDetail",
        data() {
            return {
                selectedComponent: 'artworkInfo'
            }
        },
        computed: {
            artwork() {
                return Artwork.getters('getArtworkByArtworkId')(this.$route.params.id)
            }
        },
        methods: {
            fetchRents(){
                Rent.dispatch('fetch', {artwork: this.$route.params.id})
                    .then(response => {

                    });
            }
        },
        components: {
            artworkInfo,
            artworkEdit,
            appMain

        },
        mounted() {
            //fetch rents

            //fetch reservation
        }
    }
</script>

<style scoped>

</style>
