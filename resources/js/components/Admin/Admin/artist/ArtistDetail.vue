<template>

        <app-content>
            <template slot="toolbar">
                <v-toolbar-title>{{artist.firstname}} {{artist.lastname}}</v-toolbar-title>
                <v-spacer/>
                <v-btn flat v-on:click="$router.push({ name: 'artistedit', params: { id: artist.id}})">Wijzigen</v-btn>
                <v-btn flat v-on:click="$router.go(-1)">terug</v-btn>
            </template>
            <template slot="text">
                <div><h2>Biografie</h2></div>
                <div>{{artist.bio}}</div>
                <div><h2>Kunstwerken</h2></div>

                <v-container grid-list-sm fluid>
                    <v-layout row wrap>
                        <v-flex
                                v-for="(artwork,index) in artworks" :key="index" v-on:click="$router.push({name:'artworkdetail',params:{id:artwork.id}})"
                                xs4
                                d-flex
                        >
                            <v-card flat tile class="d-flex">
                                <v-img
                                        :src="artwork.thumbnailurl"
                                        aspect-ratio="1"
                                        class="grey lighten-2"
                                >
                                    <v-layout
                                            slot="placeholder"
                                            fill-height
                                            align-center
                                            justify-center
                                            ma-0
                                    >
                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-layout>

                                    <v-layout pa-2 column fill-height class="lightbox white--text">
                                        <v-spacer></v-spacer>
                                        <v-flex shrink>
                                            <div class="subheading">{{artwork.name}}</div>
                                        </v-flex>
                                    </v-layout>
                                </v-img>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </template>
        </app-content>




</template>

<script>
    import Artist from '../../../store/orm/Artist'
    import Artwork from "@/store/orm/Artwork";
    import appContent from '../basis/content'

    export default {
        name: "ArtistDetail",
        computed: {
            artist() {
                return Artist.find(this.$route.params.id)
            },
            artworks() {
                return Artwork.query().where('artist_id', this.artist.id).get()
            }


        },
        components:{
            appContent
        }
    }
</script>

<style scoped>

</style>
