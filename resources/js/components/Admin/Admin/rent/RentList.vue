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
                                label="Zoek ontlening"
                                single-line
                                hide-details
                                v-on:click:prepend="show"
                        ></v-text-field>
                    </v-flex>
                    <v-spacer></v-spacer>


                    <create-existing-rent-dialog/>


                    <v-btn flat v-on:click="show">
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
                            <v-list class="pb-4">
                                <v-list-tile>
                                    <v-list-tile-action class="mt-4 mb-4">
                                        <v-radio-group v-model="check">
                                            <v-radio label="Alles" value="all"></v-radio>
                                            <v-radio label="Te laat" value="expired"></v-radio>
                                            <v-radio label="Teruggebracht" value="returned"></v-radio>
                                            <v-radio label="Niet teruggebracht" value="notreturned"></v-radio>
                                        </v-radio-group>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                            <v-card-actions class="mt-2">
                                <v-divider></v-divider>

                                <v-btn flat @click="menu = false">Close</v-btn>
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
                            :rows-per-page-items="rowsPerPage"
                            no-results-text="Geen ontleningen gevonden"
                    >
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">

                            <rent-list-item :rent="props.item"/>

                        </template>
                    </v-data-table>
                </template>
            </app-content>
        </template>

    </app-main>


</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import Expire from '../../../store/orm/Expire'
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
                rowsPerPage: [10],
                search: "",
                check: "all",
                loading: false,
                headers: [
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
                    {text: 'Start huur', sortable: true, value: 'started_at'},
                    {text: 'Tot', value: 'expire'},
                    {text: 'Teruggebracht', value: 'returned'}
                ]
            }
        },
        computed: {


            rents() {
                let rents = Rent.query().withAll().get()

                let mapped = rents.map(rent => {
                    rent.returned == true ? rent.returned = "Ja" : rent.returned = "Nee"
                    rent.expire = Expire.query().where('expirable_type', 'Rent').where('expirable_id', rent.id).first()
                    rent.expired = new Date() > new Date(Date.parse(rent.expire.date)) && rent.returned == 'Nee'
                    return rent
                })

                return mapped.filter(rent => {
                    switch (this.check) {
                        case "expired":
                            return new Date() > new Date(Date.parse(rent.expire.date)) && rent.returned == 'Nee';
                            break;
                        case "returned":
                            return rent.returned == 'Ja'
                            break;
                        case "notreturned":
                            return rent.returned == "Nee"
                            break;
                        default:
                            return true
                    }
                })


            },
            classObject: function () {
                return {
                    active: this.isActive && !this.error,
                    'text-danger': this.error && this.error.type === 'fatal'
                }
            }


        },
        methods: {
            getDataFromApi() {
                this.loading = true;
                Rent.deleteAll()
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
            createExistingRentDialog
        }
    }
</script>
