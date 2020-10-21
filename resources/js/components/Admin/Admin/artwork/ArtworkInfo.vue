<template>
    <v-app>
        <v-container>
            <v-layout row wrap>
                <v-toolbar flat>
                        <v-img src="http://www.tinademeyer.be/artotheek/static/img/verhuurficheverhuurfiche.9c95d3e.png"
                               width="100%">
                            <v-layout fill-height row align-center >

                                    <v-btn
                                            slot="activator"

                                            flat

                                            dark
                                            v-on:click="$emit('edit')"
                                    >
                                        kunstwerk wijzigen
                                    </v-btn>

                                    <v-btn flat dark fab small>delete<v-icon>delete_outline</v-icon></v-btn>



                                <v-spacer></v-spacer>
                                <span class="white--text mr-3 black-background display-1 ">Verhuurfiche Artotheek#44</span>
                            </v-layout>

                        </v-img>
                    <v-spacer/>

                </v-toolbar>

                <v-flex xs12>
                    <v-card flat>
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
                                        <v-btn flat v-on:click="$router.push({name:'artistdetail',params:{id:artwork.artist.id}})" class="grey--text mb-3">{{artwork.artist.firstname}} {{artwork.artist.lastname}}</v-btn>
                                        <div v-bind:class="{ 'red--text': !artwork.available }">{{beschikbaar}}</div>
                                        <div>Code: {{artwork.code}}</div>
                                        <div>Waarde: {{price}}</div>
                                        <div>Te koop: {{artwork.forsale?'Ja':'Nee'}}</div>
                                    </div>
                                </v-card-title>
                            </v-flex>


                        </v-layout>
                        <v-divider light></v-divider>
                        <v-card-actions>
                            <v-btn flat>Verwijder kunstwerk</v-btn>
                        </v-card-actions>
                    </v-card>

                </v-flex>
                <v-flex xs12>
                    <v-progress-linear v-if="loading" slot="progress" color="blue" indeterminate></v-progress-linear>
                </v-flex>

            </v-layout>
            <v-layout v-if="!loading">
                <v-flex xs12>
                    <v-card flat>
                        <v-data-table
                                flat
                                :headers="headers"
                                :items="rents"
                                hide-actions
                                class="elevation-1"
                                no-data-text="Nog geen ontleningen"
                        >
                            <template slot="items" slot-scope="props" flat>
                                <td v-on:click="$router.push({name:'userdetail',params:{id:props.item.user.id}})">{{
                                    props.item.user.firstname }} {{props.item.user.lastname }}
                                </td>
                                <td>{{ props.item.started_at }}</td>
                                <td>{{ props.item.expires }}</td>
                                <td>{{props.item.returned_at}}</td>
                            </template>

                            <template slot="footer" v-if="activeReservation">
                                <td colspan="100%">
                                    <span class="grey--text">Gereserveerd door {{activeReservation.user.firstname}} {{activeReservation.user.lastname }} tot
                                    {{activeReservation.expires}}
                                    </span>
                                </td>
                            </template>
                        </v-data-table>

                    </v-card>
                </v-flex>

            </v-layout>

        </v-container>

    </v-app>
</template>

<script>
    import Reservation from '../../../store/orm/Reservation'
    import Rent from '../../../store/orm/Rent'
    import Artwork from '../../../store/orm/Artwork'
    import Expire from "@/store/orm/Expire";
    import User from "@/store/orm/User";

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
                    {text: 'Datum verhuurd', value: 'calories', sortable: false},
                    {text: 'Einddatum verhuur', value: 'calories', sortable: false},
                    {text: 'Datum terugbezorging', value: 'fat', sortable: false},
                ],
            }
        },
        computed: {

            reservations() {
                return Reservation.getters('getReservationsByArtworkId')(this.$route.params.id)
            },
            artwork() {
                return Artwork.getters('getArtworkByArtworkId')(this.$route.params.id)
            },
            rents() {
                return Rent.getters('getRentsByArtworkId')(this.$route.params.id).map(rent=>{
                    return{
                        started_at:rent.started_at,
                        returned_at:rent.returned_at,
                        user:User.find(rent.user_id),
                        expires:Expire.query().where('expirable_type','Rent').where('expirable_id',rent.id).first().date
                    }
                })
            },

            activeRent() {
                return this.artwork.rents.find(rent => {
                    return !rent.returned
                })
            },
            activeReservation() {
                let reservation =   this.artwork.reservations.find(reservation => {
                    return reservation.active && !reservation.expired
                })

                if (reservation){
                    return{
                        started_at:reservation.started_at,
                        user:reservation.user,
                        expires:Expire.query().where('expirable_id',reservation.id).where('expirable_type','Reservation').first().date
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
            loading() {
                Artwork.getters('loading')
            },
            price(){
                if (this.artwork.price == null){
                    return "niet opgegeven"
                }

                return this.artwork.price + "€"
            },
            isSuperAdmin() {
                return this.$store.getters['entities/users/userHasRole']('superadmin')
            }
        }
    }
</script>

<style scoped>


   >>> .v-toolbar__content{
        padding:0;
    }

    .black-background{
        background-color: black;
    }


</style>
