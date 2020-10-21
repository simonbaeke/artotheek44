<template>
    <v-app>
        <v-container>
            <v-layout row wrap class="mt-5" v-if="!loading">

                <artist-list-column
                        v-for="n in 3"
                        :key="n"
                        :artists="artists"
                        :column="n - 1"
                        total-columns="3"
                        class="hidden-sm-and-down"
                ></artist-list-column>

                <artist-list-column
                        v-for="n in 2"
                        :key="n"
                        :artists="artists"
                        :column="n - 1"
                        total-columns="2"

                        class="hidden-md-and-up"

                ></artist-list-column>


            </v-layout>
        </v-container>

    </v-app>

</template>

<script>

    import Artist from '../../../store/orm/Artist'
    import artistListColumn from './ArtistListColumn.vue'
    import {EventBus} from "../../../Event";

    export default {
        data() {
            return {
                searchString: "",
                loading: false
            }
        },
        computed: {
            artists() {
                return Artist.query().get().filter(artist => {
                    let fullname = artist.firstname + artist.lastname
                    return fullname.toLowerCase().indexOf(this.searchString) > -1
                })
            }
        },

        mounted() {
            EventBus.$emit('resetSearchstring')

        },
        components: {
            artistListColumn
        },
        created() {
            EventBus.$on('search', search => {
                if (search == null) {
                    this.searchString = ""
                } else {
                    this.searchString = search.toLowerCase();

                }
            })


        }
    }
</script>
<style>
</style>
