<template>
    <v-layout row>

        <v-flex xs12>

            <v-card width="100%">
                <v-card-title primary-title>
                    <div>
                        <div class="headline">Abonnement verloopt op:</div>
                        <span>{{subscription.expires}}</span>
                    </div>
                </v-card-title>
                <v-divider></v-divider>

                <v-card-title v-if="activeReservation">
                    <div>
                        <div class="headline">Reservering</div>
                        <span>{{activeReservation.expires}}</span><br>
                        <span>{{activeReservation.artwork.name}}</span>
                    </div>
                </v-card-title>
                <v-card-actions v-if="activeReservation">
                    <v-btn color="warning" flat v-on:click="stopReservation(activeReservation)">Stop reservering</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import subscriptionHeader from './Subscription/SubscriptionHeader.vue'
    import subscriptionReservation from './Subscription/SubscriptionReservation.vue'

    export default {
        name: "UserSubscription",
        props: ['subscription', 'editing'],


        computed: {

            activeReservation() {
                for (var i = 0; i < this.subscription.reservations.length; i++) {
                    if (this.subscription.reservations[i].active) {
                        return this.subscription.reservations[i];
                    }
                }

                return null;
            }
        },
        components: {
            subscriptionHeader,
            subscriptionReservation
        },
        mounted(){
            console.log('mounted')
        }
    }
</script>

<style scoped>

</style>
