<template>
        <v-container>
            <v-card flat v-if="artist">
                <v-toolbar flat color="lime lighten-2">
                    <span class="title"> {{artist.firstname}} {{artist.lastname}}</span>
                </v-toolbar>
                <v-card-text>
                    {{artist.bio}}
                </v-card-text>

                <v-container grid-list-md fluid>
                    <v-layout row wrap>
                        <v-flex
                                v-for="artwork in artworks"
                                :key="artwork.id"
                                xs4
                        >

                            <masonry-item :object="artwork"/>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
            <div class="text-xs-center" v-if="!artist">
                <v-progress-circular
                        :size="50"
                        color="primary"
                        indeterminate
                ></v-progress-circular>
            </div>
        </v-container>

</template>

<script>
    import appMasonryGrid from '../MasonryGrid.vue'
    import masonryItem from '../MasonryItem'
    import Artist from '../../../store/orm/Artist'
    import Artwork from '../../../store/orm/Artwork'

    export default {
        name: "ArtistDetail",
        computed: {
            artist() {
                return Artist.find(this.$route.params.id)
            },

            artworks() {
                return Artwork.query().withAll().get().filter(artwork=>{
                    return artwork.artist_id == this.artist.id
                })
            }
        }
        ,
        components: {
            appMasonryGrid,
            masonryItem
        },
        mounted(){
            Artwork.dispatch('fetchArtworks',{
                artist:this.$route.params.id
            })
        }
    }
</script>

<style scoped>
    .headline {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 0.5rem;
    }

    .container {
        margin-top: 6rem;
    }

    .v-toolbar {
        background-image: linear-gradient(#dce775, #dce7754a);
    }
</style>
