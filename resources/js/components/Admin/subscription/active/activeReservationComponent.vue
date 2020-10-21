<template>
    <div>
        <span class="headline">Reservering</span>
        <v-simple-table>
            <template v-slot:default>
                <thead>
                <tr>
                    <th class="text-left">Kunstwerk</th>
                    <th class="text-left">Geldig tot</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{reservation.artwork.name}}</td>
                    <td>{{reservation.expire.date}}</td>
                    <td class="text-right">
                        <v-btn outlined>Reservering stoppen</v-btn>
                        <v-btn @click="rentReservationDialog=true" outlined>Kunstwerk ontlenen</v-btn>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>

        <confirm-dialog

                :confirming="rentReservationLoading"
                :dialog="rentReservationDialog"
                v-on:confirm="rentReservation"
                v-on:cancel="rentReservationDialog = false"
        >
            <template slot="text">Gereserveerd kunstwerk ontlenen?</template>
        </confirm-dialog>
    </div>
</template>

<script>
    import {EventBus} from "../../../../Event";
    import confirmDialog from '../../dialog/ConfirmDialog'
    import Rent from "../../../../store/orm/Rent";
    import Reservation from "../../../../store/orm/Reservation";

    export default {
        name: "activeReservationComponent",
        props: {
            reservation: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                rentReservationLoading: false,
                rentReservationDialog: false
            }
        },
        methods: {
            rentReservation() {
                this.rentReserving = true
                Rent.dispatch('createRent', {
                    subscription_id: this.reservation.subscription_id,
                    artwork_id: this.reservation.artwork_id
                }).then(response => {

                    this.rentReserving = false
                    this.rentReserveDialog = false
                    Reservation.delete(this.activeReservation.id)
                        .catch(error => {
                            EventBus.$emit('message', {
                                component: 'notificationSnackbar',
                                message: 'Reservering niet verwijderd ' + error,
                                type: 'error'
                            })
                        })
                    EventBus.$emit('showorder')
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Ontlening voor gereserveerd kunstwerk aangemaakt'
                    })

                }).catch(error => {
                    console.log(error.message)
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Fout: Ontlening voor gereserveerd kunstwerk niet aangemaakt ' + error + " " + error.response.data.message,
                        type: 'error'
                    })
                })
            }
        },
        components: {
            confirmDialog
        }
    }
</script>

<style scoped>

</style>
