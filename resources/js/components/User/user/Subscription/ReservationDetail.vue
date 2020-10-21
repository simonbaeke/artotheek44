<template>
    <v-card class="ma-4 elevation-0">
        <v-card-title>Reservering</v-card-title>
        <v-card-text>
            <div>
                Kunstwerk: {{artwork.name}}
            </div>
            <div>
                Einddatum reservering: {{reservation.expires_at}}
            </div>
        </v-card-text>
        <v-card-actions>
            <v-btn text
                   :disabled="stopping"
                   :loading="stopping"
                   @click="stopReservation"
            >Stop reservering
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import Artwork from '../../../../store/orm/Artwork'
    import {EventBus} from "../../../../Event";
    import Reservation from '../../../../store/orm/Reservation'


    export default {
        name: "ReservationDetail",
        props: {
            reservation: {
                required: true
            }
        },
        data() {
            return {
                stopping: false
            }
        },
        computed: {
            artwork() {
                return Artwork.find(this.reservation.artwork_id)
            }
        },
        methods: {
            stopReservation() {
                this.stopping = true
                Reservation.dispatch('stopReservation', this.reservation)
                    .then((response) => {
                        this.stopping = false
                        EventBus.$emit('message', {
                            component: "notificationSnackbar",
                            message: "Reservering gestopt",
                            type: 'success'
                        })
                    })
                    .catch(error=>{
                        EventBus.$emit('message',{
                            component:"notificationsnackbar",
                            message:"reservering niet gestopt " + error.response ,
                            type:'error'
                        })
                    })
            }
        },

    }
</script>

<style scoped>

</style>
