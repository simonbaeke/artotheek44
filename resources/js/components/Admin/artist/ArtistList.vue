<template>
    <app-content>
        <template slot="toolbar">
            <v-flex xs6>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Zoek kunstenaar"
                        single-line
                        hide-details
                ></v-text-field>
            </v-flex>
            <v-spacer></v-spacer>
            <v-btn text v-on:click="$router.push({name:'artistcreate'})">Nieuwe kunstenaar</v-btn>
        </template>
        <template slot="text">
            <v-data-table
                    :headers="headers"
                    :items="artists"
                    :loading="loading"
                    :search="search"
                    :rows-per-page-items="rowsPerPage"
                    no-results-text="Niemand gevonden"
            >
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template v-slot:item="{item}" v-if="!loading" v-on:click="alert('alert')">
                    <artist-list-row :artist="item"/>
                </template>
            </v-data-table>
        </template>
    </app-content>
</template>

<script>
    import Artist from '../../../store/orm/Artist'
    import artistListRow from './ArtistListRow'
    import appContent from '../basis/content'

    export default {
        name: "ArtistList",

        data() {
            return {
                search: "",
                headers: [
                    {
                        text: 'Voornaam',
                        align: 'left',
                        sortable: true,
                        value: 'firstname'
                    },
                    {text: 'Familienaam', sortable: false, value: 'lastname'},
                    {text: 'Afkorting', sortable: false, value: 'short'}
                ],
                rowsPerPage: [10],
                loading: false
            }
        },
        computed: {
            artists() {
                return Artist.all()
            }
        },
        components: {
            artistListRow,
            appContent
        },
        mounted(){
            this.loading = true
            Artist.dispatch('fetch').then(response=>{
                this.loading=false
            })
        }
    }
</script>

<style scoped>

</style>
