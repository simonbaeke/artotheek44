<template>
    <div>
        <create-rent-from-reservation
                v-if="reservationId"
                :reservationId="reservationId"
                :dialog="createRentFromReservationDialog"
                @close="closeCreateRentFromReservationDialog"
        />
        <stop-reservation-button :dialog="stopReservationDialog"/>


    </div>
</template>

<script>
    import {EventBus} from "@/Event";
    import {Dialog} from "@/Dialog";
    import createRentFromReservation from '../rent/CreateRentFromReservationDialog.vue'
    import stopReservationButton from '../buttons/StopReservationButton'
    import Subscription from '../../../store/orm/Subscription.js'
    import Reservation from "@/store/orm/Reservation";

    export default {
        name: "EditReservation",
        data() {
            return {
                createRentFromReservationDialog: false,
                reservationId: null,
                stopReservationDialog: new Dialog({
                    reservation:null
                })

            }
        },
        methods: {
            closeCreateRentFromReservationDialog() {
                this.reservationId = null
                this.createRentFromReservationDialog = false
            }
        },
        created() {

            EventBus.$on('stopreservation', reservation => {
                console.log(reservation)
                this.stopReservationDialog.open({reservation:reservation})
            });
            EventBus.$on('ontleenreservation', reservationId => {

                let reservation = Reservation.find(reservationId)
                let subscription = Subscription.find(reservation.subscription_id)
                if (!subscription.confirmed){
                    this.$store.commit('setError', 'Kan ontlening niet aanmaken: abonnement niet geconfirmeerd')
                    return
                }
                this.createRentFromReservationDialog = true;
                this.reservationId = reservationId

            });
            EventBus.$on('verlengreservation', reservation => {
                console.log('verlengreservation')
            });

            this.reservationId = null
        },
        destroyed() {
            EventBus.$off('stopreservation')
            EventBus.$off('ontleenreservation')
            EventBus.$off('verlengreservation')

        },
        components: {
            createRentFromReservation,
            stopReservationButton
        }
    }
</script>

<style scoped>

</style>
