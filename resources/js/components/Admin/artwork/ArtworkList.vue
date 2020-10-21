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
                    <v-flex xs2 class="ml-3 mt-4">
                        <v-checkbox
                                label="Verkocht"
                                v-model="showSold"
                        />
                    </v-flex>


                    <v-spacer/>
                    <v-btn text v-on:click="$router.push({name:'artworkcreate'})">Nieuw Kunstwerk</v-btn>

                </template>
                <template slot="text">

                    <v-data-table

                            :headers="headers"
                            :items="artworks"
                            :loading="loading"
                            :search="search"
                            class="elevation-0"

                            no-results-text="Niks gevonden"
                    >
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template v-slot:body="{ items }">
                            <tbody>
                            <tr v-for="(item,index) in items" :key="item.id">
                                <td v-on:click="showDetails(item)">{{ item.name }}</td>
                                <td v-if="item.artist!=null">{{ item.artist.fullname }}</td>
                                <td>{{ item.code}}</td>
                                <td v-if="item.available != null" >{{ item.available? "beschikbaar" : "Niet beschikbaar"}}</td>
                                <td v-else>/</td>
                            </tr>
                            </tbody>

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
                        sortable: true,
                        value: 'name'
                    },
                    {text: 'Kunstenaar', sortable: false, value: 'artist.fullname'},
                    {text: 'Code', sortable: false, value: 'code'},

                    {text: 'Beschikbaar', sortable: false, value: 'available'}
                ],
                rowsPerPage: [10],
                loading:false,
                showSold:false
            }
        },
        computed: {
            artworks() {
                return Artwork.query().where('sold',this.showSold).with('artist').get()
            }
        },
        methods: {

            showDetails(artwork) {
                this.$router.push({name: 'artworkdetail', params: {id: artwork.id}});

            }
        },
        components: {
            appMain,
            appContent
        },
        mounted() {

            this.loading = true
            Artwork.dispatch('fetchArtworks')
                .then(response => {
                    this.loading = false
                    Artwork.dispatch('fetchArtworks',{available:true})


                }).catch(error => {
                this.loading = false


            })

        }
    }
</script>
