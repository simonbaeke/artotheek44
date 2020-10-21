<template>
    <app-main>
        <template slot="title">Reserveringen</template>
        <template slot="content">
            <app-content>
                <template slot="toolbar">
<!--
                    <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-width="200"
                            :position-x="x"
                            :position-y="y"
                            absolute
                    >
                        <v-card class="elevation-0">
                            <v-list>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-checkbox
                                                :input-value="filter.expired.value"
                                                :indeterminate="filter.expired.indeterminate"
                                                v-on:click.prevent="updateFilter(filter.expired)"
                                        ></v-checkbox>
                                    </v-list-tile-action>
                                    <v-list-tile-title>Verlopen</v-list-tile-title>
                                </v-list-tile>
                                <v-list-tile>
                                    <v-list-tile-action>
                                        <v-checkbox
                                                :input-value="filter.active.value"
                                                :indeterminate="filter.active.indeterminate"
                                                v-on:click.prevent="updateFilter(filter.active)"
                                        ></v-checkbox>
                                    </v-list-tile-action>
                                    <v-list-tile-title>Actief</v-list-tile-title>
                                </v-list-tile>
                            </v-list>

                            <v-card-actions>
                                <v-btn text @click="menu = false">close</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-menu>
-->

                    <v-flex xs6>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Search"
                                single-line
                                hide-details

                        />
                    </v-flex>
                    <v-spacer/>
                   <!-- <v-btn text v-on:click="showFilterMenu">
                        filter
                        <v-icon right>filter_list</v-icon>

                    </v-btn>-->
                </template>
                <template slot="text">
                    <v-data-table

                            :headers="headers"
                            :items="reservations"
                            :items-per-page="10"
                            :loading="loading"
                            class="elevation-0"
                            :search="search"
                    >


                    </v-data-table>
                </template>
            </app-content>
        </template>
    </app-main>


</template>

<script>
    import Reservation from '../../../store/orm/Reservation'

    import editReservationDialog from './EditReservationDialog.vue'
    import createRentFromReservation from '../rent/CreateRentFromReservationDialog.vue'
    import reservationMenu from '../reservation/EditReservationMenu'
    import Expire from "../../../store/orm/Expire";
    import appMain from '../basis/main'
    import appContent from '../basis/content'


    export default {
        data() {
            return {
                menu: false,
                makeRentDialog: false,
                selectedReservation: null,
                x: 0,
                y: 0,
                filter: {
                    active: {
                        value: false,
                        indeterminate: true
                    },
                    expired: {
                        value: false,
                        indeterminate: true
                    }
                },
                active: true,
                updating: false,
                itemToEdit: {},
                pagination: {
                    descending: true,
                    page: 1,
                    rowsPerPage: 10,// -1 for All
                    sortBy: 'id',
                },
                search: "",
                totalReservations: 0,
                loading: true,
                headers: [
                    {text: 'Id', sortable: false, value: 'id'},

                    {
                        text: 'Kunstwerk',
                        align: 'left',
                        sortable: false,
                        value: 'artwork.name'
                    },
                    {text: 'Gebruiker', sortable: false, value: 'user.firstname'},
                    {text: 'Tot', value: 'expires'},
                    {text: 'Verlopen', value: 'expired'},
                    {text: 'Actief', value: 'active'},
                ]
            }
        },
        computed: {
            queryData() {
                return {
                    page: this.pagination.page,
                    rowsPerPage: this.pagination.rowsPerPage,// -1 for All
                    sort: this.sortColumn,
                    search: this.search,
                    active: this.filterValue(this.filter.active),
                    expired: this.filterValue(this.filter.expired)
                }
            },

            sortColumn() {
                var sortDirection = " ";
                if (this.pagination.descending) {
                    sortDirection = "-"
                }

                return sortDirection + this.pagination.sortBy
            },
            reservations() {
                return this.$store.getters['entities/reservations/getAllReservations'].sort(function (a, b) {
                    return b.id - a.id
                }).map(reservation => {
                    return {
                        artwork: reservation.artwork,
                        user: reservation.user,
                        expires: Expire.query().where('expirable_type', 'Reservation').where('expirable_id', reservation.id).first().date,
                        id: reservation.id,
                        expired: reservation.expired?'Ja':'Nee',
                        active: reservation.active?'Ja':'Nee'
                    }
                })
            },
            status() {
                return this.reservations.map(reservation => {

                })
            }
        },
        watch: {
            pagination: {
                handler() {
                    this.getDataFromApi();
                },
                deep: true
            }
        },

        methods: {
            getDataFromApi() {
                this.loading = true;
                Reservation.deleteAll()
                Reservation.dispatch('fetchAll', this.queryData)
                    .then(response => {
                        this.loading = false;
                        this.totalReservations = response.data.meta.total;
                    })
                    .catch(error => {
                        this.loading = false
                    })

            },
            showFilterMenu(e) {
                e.preventDefault()
                this.menu = false
                this.x = e.clientX
                this.y = e.clientY
                this.$nextTick(() => {
                    this.menu = true
                })
            },
            ontleen(reservation) {
                this.selectedReservation = reservation
                this.makeRentDialog = true
            },
            stopReservation(reservation) {

            },
            closeDialog() {
                this.makeRentDialog = false
                this.selectedReservation = null
            },

            updateFilter(filter) {
                if (filter.indeterminate) {
                    filter.indeterminate = false
                    filter.value = true

                }

                else if (filter.value) {
                    filter.indeterminate = false
                    filter.value = false

                }

                else if (!filter.value) {
                    filter.indeterminate = true
                    filter.value = false

                }

              //  this.getDataFromApi()
            },

            filterValue(filter) {
                if (filter.indeterminate) {
                    return "indeterminate"
                }

                return filter.value
            }
        },

        components: {
            editReservationDialog,
            createRentFromReservation,
            reservationMenu,
            appMain,
            appContent
        },
        mounted(){
            this.getDataFromApi()
        }
    }
</script>
