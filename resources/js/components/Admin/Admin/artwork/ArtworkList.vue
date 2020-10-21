<template>
    <app-main>
        <template slot="title">
           Kunstwerken
        </template>
        <template slot="content">
            <app-content>
                <template slot="toolbar">
                    <v-flex xs6>
                        <v-text-field

                                v-model="search"
                                append-icon="search"
                                label="Zoek kunstwerk"
                                single-line
                                hide-details
                        />
                    </v-flex>
                    <v-spacer/>
                    <v-btn flat v-on:click="$router.push({name:'artworkcreate'})">Nieuw Kunstwerk</v-btn>

                </template>
                <template slot="text">

                        <v-data-table

                                :headers="headers"
                                :items="artworks"
                                :loading="loading"
                                :search="search"
                                class="elevation-0"
                                :rows-per-page-items="rowsPerPage"
                                no-results-text="Niks gevonden"
                        >
                            <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                            <template slot="items" slot-scope="props">
                                <td v-on:click="showDetails(props.item)">{{ props.item.name }}</td>
                                <td>{{ props.item.artist.fullname }}</td>
                                <td>{{ props.item.code}}</td>
                                <td>{{ props.item.available? "beschikbaar" : "Niet beschikbaar"}}</td>
                            </template>
                        </v-data-table>
                </template>
            </app-content>


        </template>
    </app-main>


</template>

<script>
    import Artwork from '../../../store/orm/Artwork'
    import appMain from '../basis/main'
    import appContent from '../basis/content'

    export default {
        data() {
            return {
                search: "",
                headers: [
                    {
                        text: 'Kunstwerk',
                        align: 'left',
                        sortable: false,
                        value: 'name'
                    },
                    {text: 'Artiest', sortable: false, value: 'artist.fullname'},
                    {text: 'Code', sortable: false, value: 'code'},

                    {text: 'Beschikbaar', sortable: false, value: 'available'}
                ],
                rowsPerPage: [10]
            }
        },
        computed: {
            artworks() {
                return Artwork.getters('artworks')
            },
            loading(){
                return Artwork.getters('loading')
            }
        },
        methods: {

            showDetails(artwork) {
                this.$router.push({name: 'artworkdetail', params: {id: artwork.id}});

            }
        },
        components:{
            appMain,
            appContent
        }
    }
</script>
