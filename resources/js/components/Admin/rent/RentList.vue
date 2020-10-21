<template>

    <app-main>
        <template slot="title">Ontleningen</template>

        <template slot="content">
            <app-content>
                <template slot="toolbar">
                    <v-flex xs6>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                prepend-icon=""
                                label="Zoek ontlening op kunstwerk, code, gebruiker of lidkaart"
                                single-line
                                hide-details
                                v-on:click:prepend="show"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>


                    <create-existing-rent-dialog/>


                    <v-btn text v-on:click="show">
                        filter
                        <v-icon right>filter_list</v-icon>
                    </v-btn>
                    <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-width="200"
                            :position-x="x"
                            :position-y="y"
                            absolute
                    >
                        <v-card class="elevation-0">
                            <v-card-title class="mb-3">Selecteer</v-card-title>
                            <v-card-text>
                                <v-radio-group v-model="check">
                                    <v-radio label="Alles" value="all"></v-radio>
                                    <v-radio label="Te laat" value="expired"></v-radio>
                                    <v-radio label="Teruggebracht" value="returned"></v-radio>
                                    <v-radio label="Niet teruggebracht" value="notreturned"></v-radio>
                                </v-radio-group>
                            </v-card-text>
                            <v-divider></v-divider>
                            <v-card-actions class="mt-2">


                                <v-btn text @click="menu = false">Close</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-menu>

                </template>
                <template slot="text">

                    <v-data-table

                            :headers="headers"
                            :items="rents"
                            :loading="loading"
                            :search="search"
                            sort-by="started_at"
                            :sort-desc="sortDesc"
                            no-results-text="Geen ontleningen gevonden"
                    >
                        <template v-slot:body="{ items }">
                            <tbody>

                            <rent-list-item v-for="(item,index) in items" :key="index" :rent="item"/>

                            </tbody>
                        </template>


                    </v-data-table>
                </template>
            </app-content>
        </template>

    </app-main>


</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import rentListItem from './RentListItem'
    import appMain from '../basis/main'
    import appContent from '../basis/content'
    import createExistingRentDialog from './CreateExistingRentDialog'

    export default {
        data() {
            return {
                showFilter: false,
                menu: false,
                x: 0,
                y: 0,
                search: "",
                check: "all",
                loading: false,
                sortDesc:true


            }
        },
        computed: {


            rents() {

                if (this.check == 'notreturned') {
                    return Rent.query().where('returned', false).withAll().get()

                }

                if (this.check == 'returned') {
                    return Rent.query().where('returned', true).withAll().get()

                }

                if (this.check == 'expired'){
                    return Rent.query()
                        .where('expired',true)
                        .where('returned',false).withAll().get()

                }


                return Rent.query().withAll().get()

            }

            ,
            headers() {
                let header = [
                    {
                        text: 'Kunstwerk',
                        align: 'left',
                        sortable: true,
                        value: 'artwork.name'
                    }, {
                        text: 'Code',
                        align: 'left',
                        sortable: 'true',
                        value: 'artwork.code'
                    },
                    {text: 'Gebruiker', sortable: true, value: 'user.firstname'},
                    {text: 'Lidkaartnummer', sortable: false, value:'subscriptionnumber'},
                    {text: 'Start huur', sortable: true, value: 'started_at'},
                    {text: 'Tot', value: 'expire.date'},
                    {text: 'Teruggebracht', value: 'returned'},
                ]

                if (this.$store.getters['entities/users/userHasRole']('superadmin')) {
                    header.push({
                        text: 'Verwijderen', sortable: false
                    })
                }
                return header


            }


        },
        methods: {
            getDataFromApi() {
                this.loading = true;
                //Rent.deleteAll()
                Rent.dispatch('fetchAll').then(response => {
                    this.loading = false
                })
            }
            ,
            show(e) {
                e.preventDefault()
                this.menu = false
                this.x = e.clientX
                this.y = e.clientY
                this.$nextTick(() => {
                    this.menu = true
                })
            }
        },
        mounted() {
            this.getDataFromApi()
        },
        components: {
            rentListItem,
            appMain,
            appContent,
            createExistingRentDialog,
        }
    }
</script>
