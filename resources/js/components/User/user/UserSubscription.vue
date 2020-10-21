<template>
    <v-layout>

        <v-flex class="mb-2">
            <v-card flat class="pa-4">
                <v-layout row wrap class="pb-4">
                    <v-flex xs12 md12>
                        <v-card-title primary-title><span>Lidkaart</span></v-card-title>
                        <v-card-text>
                            <div class="grey--text">Lidkaartnummer: {{subscription.number}}</div>
                            <div class="grey--text">Geldig tot: {{subscription.expires_at}}</div>
                        </v-card-text>

                        <v-divider class="my-4"></v-divider>


                    <rent-detail
                            v-if="rent!=null"
                            :rent="rent"
                    />

                    <reservation-detail
                            v-if="reservation!=null"
                            :reservation="reservation"
                    />
                    </v-flex>

                    <v-card-title primary-title v-if="!rent && !reservation"><h1>Geen huidige items</h1></v-card-title>


                </v-layout>
            </v-card>
        </v-flex>

    </v-layout>

</template>

<script>
    import Reservation from '../../../store/orm/Reservation'
    import Rent from '../../../store/orm/Rent'
    import Subscription from '../../../store/orm/Subscription'
    import Expire from '../../../store/orm/Expire'
    import rentDetail from './Subscription/RentDetail'
    import reservationDetail from './Subscription/ReservationDetail'

    export default {
        name: "UserSubscription",
        props: ['subscription', 'editing'],
        data() {
            return {
                stopping: false
            }
        },
        computed: {
            reservation() {
                return Reservation.query()
                    .where('subscription_id',this.subscription.id)
                    .where('active',true)
                    .where('expired',false)
                    .first()
            },
            rent() {
                return Rent.query()
                    .where('subscription_id',this.subscription.id)
                    .where('returned',false)
                    .first()
            }

        },
        components:{
            rentDetail,
            reservationDetail
        }
    }
</script>

<style scoped>

</style>
