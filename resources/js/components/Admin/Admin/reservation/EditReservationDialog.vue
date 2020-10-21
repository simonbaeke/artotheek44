<template>
    <v-dialog v-model="dialog" max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline">Wijzig Reservering</span>
            </v-card-title>

            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm6 md6>
                            <v-text-field v-model="reservation.artwork.name" label="Kunstwerk"
                                          disabled></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm12 md6>
                            <v-text-field v-model="reservation.user.firstname" label="Gebruiker"
                                          disabled></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm12 md12>
                            <v-date-picker :landscape="true" color="blue" v-model="reservation.expires" no-title
                                           scrollable>
                                <v-spacer></v-spacer>
                                <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                            </v-date-picker>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-switch label="Aktief" v-model="reservation.active"></v-switch>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="$emit('close')">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Reservation from '../../../store/orm/Reservation'

    export default {
        name: "EditReservationDialog",
        props: ['dialog', 'reservation'],
        data() {
            return {
                editRerservation: {}
            }
        },
        methods: {
            save(reservation){
                let editedItem = Object.assign({}, item)

            }
        }
    }
</script>

<style scoped>

</style>
