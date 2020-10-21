<template>
    <v-btn
            v-if="user.id>-1"
            color="success"
            :loading="loading"
            outlined v-on:click="makeReservation(artwork_id)">Reserveer
    </v-btn>
</template>

<script>

    import Reservation from '../../store/orm/Reservation'
    import Artwork from '../../store/orm/Artwork'
    import {EventBus} from "../../Event";

    export default {
        name: "ReservationButton",
        props: ['artwork_id'],
        data() {
            return {
                loading: false
            }
        },
        computed: {
            artwork(){
                return Artwork.find(this.artwork_id)
            },
            user() {

                return this.$store.getters['entities/users/loggedInUser']
            }
        },
        methods: {
            makeReservation(artwork_id) {
                this.loading = true;
                Reservation.dispatch('makeReservation', artwork_id)
                    .then(response => {

                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: this.artwork.name +  "Gereserveerd"
                        })
                        this.loading = false;
                        console.log(response)
                    })
                    .catch(error => {
                        this.loading = false
                        if (error.response.status == 403) {
                            EventBus.$emit('message', {
                                component: 'notificationSnackbar',
                                message: 'Reservering niet aangemaakt: log in om te reserveren'
                            })

                            return
                        }
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: this.artwork.name  + 'niet gereserveerd: ' + error.response.data.message,
                            type:'error'
                        })

                        //TODO: load artwork
                    });
            },
        }
    }
</script>

<style scoped>

</style>
