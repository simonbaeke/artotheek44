<template>
    <v-container>
        <v-alert outlined  color="red" :value="error" >Er heeft zich een fout voorgedaan</v-alert>

        <v-alert v-if="!loading && !error" outlined :value="artworks.length == 0" color="grey">Geen resultaten <i
                class="far fa-sad-tear"></i></v-alert>
        <v-layout row v-if="artworks.length>0">
            <v-flex xs-12>
                <app-masonry-grid :artworks="artworks"></app-masonry-grid>
            </v-flex>
        </v-layout>
        <v-layout v-if="loading" class="text-center">
            <v-flex xs12>

                <div class="center">
                    <v-progress-circular
                            class="middle"
                            :size="70"
                            :width="7"
                            color="#044E7F"
                            indeterminate
                    ></v-progress-circular>
                </div>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import masonryGrid from './MasonryGrid.vue'
    import {EventBus} from "../../Event";
    import Artwork from '../../store/orm/Artwork'

    export default {
        name: "Catalogus",
        data() {
            return {
                available: false,
                searchString: "",
                filter: "",
                fullscreenUrl: "",
                showFullscreen: false,
                selectedObject: [],
                loading: false,
                error: false
            }
        },
        components: {
            appMasonryGrid: masonryGrid,
        },
        computed: {
            artworks() {
                return this.$store.getters['entities/artworks/artworks'].filter(artwork => {
                    return (artwork.name.toLowerCase().indexOf(this.searchString) > -1 ||
                        artwork.artist.firstname.toLowerCase().indexOf(this.searchString) > -1 ||
                        artwork.artist.lastname.toLowerCase().indexOf(this.searchString) > -1) &&
                        (this.filter == "" || this.filter.indexOf(artwork.type.name) > -1) &&
                        (!this.available || (this.available && artwork.available))
                })
            }


        },
        mounted() {
            EventBus.$emit('resetSearchstring')
            if (this.artworks.length == 0) {
                this.loading = true
            }

            Artwork.dispatch('fetchArtworks')
                .then(response => {
                    this.loading = false
                    setTimeout(() => {
                        Artwork.dispatch('fetchArtworks',{available:true})
                    }, 1000);


                }).catch(error => {
                this.error = true
                this.loading=false


            })
        },
        created() {
            EventBus.$on('search', search => {
                if (search == null) {
                    this.searchString = ""
                } else {
                    this.searchString = search.toLowerCase();

                }
            })

            EventBus.$on('filter', filter => {
                this.filter = filter.filter.getFilter()
                this.available = filter.beschikbaar
            })
        }
    }
</script>


<style scoped>
    .container {
        margin-top: 4rem;
    }

    .center{
        height:100vh;
        position: relative;
    }

    .middle{
        position: absolute;
        top:50%;
        left:50%;
        transform:translateX(-50%);
        transform:translateY(-50%);
    }
</style>
