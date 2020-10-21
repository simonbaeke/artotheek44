<template>
    <v-app v-if="artwork!=null">
        <v-container>
            <v-layout row wrap>
                <v-toolbar text>
                    <v-img src="http://www.tinademeyer.be/artotheek/static/img/verhuurficheverhuurfiche.9c95d3e.png"
                           width="100%">
                        <v-layout fill-height row align-center>

                            <v-btn
                                    slot="activator"

                                    text

                                    dark
                                    v-on:click="$emit('edit')"
                            >
                                kunstwerk wijzigen
                            </v-btn>


                            <v-btn
                                    text
                                    dark
                                    v-if="isSuperAdmin"
                                    v-on:click="deleteDialog=true"
                            >
                                verwijderen
                                <v-icon>delete_outline</v-icon>
                            </v-btn>

                            <v-btn
                                    text
                                    dark
                                    v-if="isAdmin &&sellable"
                                    v-on:click="$emit('sell')">
                                Kunstwerk verkopen
                            </v-btn>

                            <v-spacer></v-spacer>
                            <span class="white--text mr-3 black-background display-1 ">Verhuurfiche Artotheek#44</span>
                        </v-layout>

                    </v-img>
                    <v-spacer/>

                </v-toolbar>

                <v-flex xs12>
                    <v-card text>
                        <v-layout class="pa-4">
                            <v-flex xs1 md1>


                            </v-flex>
                            <v-flex xs11 md4>
                                <v-img
                                        :src="artwork.thumbnailurl"
                                        height="14rem"
                                        contain
                                ></v-img>
                            </v-flex>
                            <v-flex xs12 md7>
                                <v-card-title primary-title align-end>
                                    <div>
                                        <div class="headline">{{artwork.name}}</div>
                                        <v-btn text
                                               v-on:click="$router.push({name:'artistdetail',params:{id:artwork.artist.id}})"
                                               class="grey--text mb-3">{{artwork.artist.firstname}}
                                            {{artwork.artist.lastname}}
                                        </v-btn>
                                        <div v-if="artwork.available != null"
                                             v-bind:class="{ 'red--text': !artwork.available=='true' }">{{beschikbaar}}
                                        </div>
                                        <div>Code: {{artwork.code}}</div>
                                        <div>Waarde: {{price}}</div>
                                        <div>Te koop: {{artwork.forsale?'Ja':'Nee'}}</div>
                                        <div>Afmetingen: {{artwork.height}} x {{artwork.width}} x {{artwork.length}}
                                        </div>
                                    </div>
                                </v-card-title>
                            </v-flex>

                        </v-layout>
                        <v-divider light></v-divider>
                    </v-card>
                </v-flex>

            </v-layout>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card text>
                        <v-data-table
                                :loading="loading"
                                text
                                :headers="headers"
                                :items="rents"
                                hide-default-footer
                                class="elevation-1"
                                no-data-text="Nog geen ontleningen"
                        >

                            <template v-slot:body="{ items }">
                                <tbody>
                                <tr v-for="(item,index) in items" :key="item.id">
                                    <td v-on:click="$router.push({name:'userdetail',params:{id:item.user.id}})"
                                        v-if="item.user !=null"
                                    >{{
                                        item.user.firstname }} {{item.user.lastname }}
                                    </td>
                                    <td>{{ item.started_at }}</td>
                                    <td>{{ item.expires_at}}</td>
                                    <td>{{item.returned_at}}</td>
                                </tr>

                                </tbody>
                            </template>


                            <template slot="footer" v-if="activeReservation">
                                <td colspan="100%" v-if="activeReservation.user != null">
                                    <span class="grey--text">Gereserveerd door {{activeReservation.user.firstname}} {{activeReservation.user.lastname }} tot
                                    {{activeReservation.expires}}
                                    </span>
                                </td>
                            </template>
                        </v-data-table>

                        <artwork-sale-info v-if="artwork.sold && sale!= null" :sale="sale"/>
                    </v-card>
                </v-flex>

            </v-layout>

        </v-container>
        <confirm-dialog
                v-if="isSuperAdmin"
                :dialog="deleteDialog"
                :confirming="deleting"
                v-on:confirm="deleteArtwork"
                v-on:cancel="deleteDialog=false"
        >
            <template slot="text">Verwijder kunstwerk?</template>
        </confirm-dialog>
    </v-app>
</template>

<script>
    import Reservation from '../../../store/orm/Reservation'
    import Rent from '../../../store/orm/Rent'
    import Artwork from '../../../store/orm/Artwork'
    import Expire from "../../../store/orm/Expire";
    import Sale from "../../../store/orm/Sale";
    import confirmDialog from '../dialog/ConfirmDialog'
    import ArtworkSaleInfo from '../artwork/ArtworkSaleInfo'

    import {EventBus} from "../../../Event";

    export default {
        name: "ArtworkInfo",
        data() {
            return {
                headers: [
                    {
                        text: 'Ontlener',
                        align: 'left',
                        sortable: false,
                        value: 'name'
                    },
                    {text: 'Begindatum verhuur', value: 'calories', sortable: false},
                    {text: 'Einddatum verhuur', value: 'calories', sortable: false},
                    {text: 'Datum terugbezorging', value: 'fat', sortable: false},
                ],
                deleteDialog: false,
                deleting: false,
                loading: false
            }
        },
        methods: {
            deleteArtwork() {
                this.deleting = true
                Artwork.dispatch('deleteArtwork', this.artwork.id).then(response => {
                    this.deleteDialog = false
                    this.deleting = false
                    Artwork.delete((record) => {
                            return record.id == this.$route.params.id
                        }
                    )
                    this.$router.push({name: 'artworklist'})
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Kunstwerk is verwijderd'
                    })


                })
                    .catch(error => {
                        this.deleteDialog = false
                        this.deleting = false
                        console.log(JSON.parse(error.request.response).message)
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'kunstwerk kan niet verwijderd worden \n ' + JSON.parse(error.request.response).message,
                            type: 'error'
                        })
                    })
            },
            fetchRents() {
                this.loading = true

                let rents = Rent.dispatch('fetchAll', {artwork: this.$route.params.id})
                let reservations = Reservation.dispatch('fetchAll', {artwork: this.$route.params.id})

                Promise.all([rents, reservations]).then(response => {
                    this.loading = false
                }).catch(error => {
                    this.loading = false
                })


            }
        },
        computed: {
            reservations() {
                return Reservation.getters('getReservationsByArtworkId')(this.$route.params.id)
            },
            artwork() {
                return Artwork.getters('getArtworkByArtworkId')(this.$route.params.id)
            },
            sale() {

                if (this.artwork != null) {
                    return Sale.query().where('artwork_id', this.artwork.id).first()

                }

                return {
                    user_id:null,
                    user_info:{
                        firstname:null,
                        lastname:null,
                        email:null,
                        phone:null
                    }
                }
            },
            rents() {
                return Rent.query().where('artwork_id', this.artwork.id).withAll().get()


            },

            activeRent() {

                return this.artwork.rents.find(rent => {
                    return !rent.returned
                })
            },
            activeReservation() {
                let reservation = this.artwork.reservations.find(reservation => {
                    return reservation.active && !reservation.expired
                })

                if (reservation) {
                    return {
                        started_at: reservation.started_at,
                        user: reservation.user,
                        expires: Expire.query().where('expirable_id', reservation.id).where('expirable_type', 'Reservation').first().date
                    }
                }
                return null


            },
            beschikbaar() {
                if (this.artwork.available) {
                    return 'Beschikbaar'
                }

                return 'Niet beschikbaar'
            },
            price() {
                if (this.artwork.price == null) {
                    return "niet opgegeven"
                }

                return this.artwork.price + "€"
            },
            isSuperAdmin() {
                return this.$store.getters['entities/users/userHasRole']('superadmin')
            },

            isAdmin() {
                return this.$store.getters['entities/users/userHasRole']('admin')

            },
            sellable() {
                return this.artwork.forsale && this.artwork.available
            }
        },
        components: {
            confirmDialog,
            ArtworkSaleInfo
        },
        mounted() {
            this.fetchRents()

        }
    }
</script>

<style scoped>


    >>> .v-toolbar__content {
        padding: 0;
    }

    .black-background {
        background-color: black;
    }


</style>
