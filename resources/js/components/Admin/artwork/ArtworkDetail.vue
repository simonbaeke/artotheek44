<template>
    <app-main>
        <template slot="content">
            <component
                    :is="selectedComponent"
                    :artwork="artwork"
                    v-on:sell="selectedComponent='artworkSale'"
                    v-on:cancel="selectedComponent='artworkInfo'"
                    v-on:edit="selectedComponent = 'artworkEdit'"/>
        </template>

    </app-main>


</template>

<script>
    import artworkInfo from './ArtworkInfo.vue'
    import Artwork from '../../../store/orm/Artwork'
    import artworkEdit from './ArtworkEdit.vue'
    import artworkSale from './ArtworkSale'
    import appMain from '../basis/main'
    import Sale from '../../../store/orm/Sale'

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
        watch: {
            artwork() {
                if (this.artwork != null) {
                    console.log('artwork')

                    if (this.artwork.sold) {
                        window.axios.get('/api/sale/' + this.artwork.id).then(response => {
                            Sale.insertOrUpdate({data: response.data.data})


                        }).catch(error => {


                        })
                    }
                }
            }
        },
        components: {
            artworkInfo,
            artworkEdit,
            artworkSale,
            appMain

        },
        mounted() {
            Artwork.dispatch('fetchArtworks', {available: true})

        }
    }
</script>

<style scoped>

</style>
