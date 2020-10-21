<template>
    <v-flex xs12 sm6 md4 class="pr-2 mt-6">
        <v-list>
            <v-list-item v-for="artist in columnArtists" :key="artist.id">
                <v-list-item-content>
                    <router-link :to="{name: 'userArtistDetail', params: {id: artist.id}}">
                        {{artist.firstname}} {{artist.lastname}}
                    </router-link>

                </v-list-item-content>

            </v-list-item>
        </v-list>
    </v-flex>
</template>

<script>
    export default {
        name: "ArtistListColumn",
        props: ['artists','column', 'totalColumns'],
        computed: {
            columnArtists() {
                let artistsPerColumn = Math.ceil(this.artists.length / this.totalColumns)

                if (this.column === this.totalColumns) {
                    return this.artists.slice(artistsPerColumn * this.column)

                }

                return this.artists.slice(artistsPerColumn * this.column, artistsPerColumn * (this.column + 1) )
            }
        }
    }
</script>

<style scoped>

</style>
