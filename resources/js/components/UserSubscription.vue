<template>
    <v-card width="100%">
        <v-card-title primary-title>
            <div>
                <div class="headline">Abonnement verloopt op:</div>
                <span>{{subscription.expires}}</span>
            </div>
        </v-card-title>
        <v-divider></v-divider>

        <v-card-title v-if="activeReservation">
            <div v-for="reservation in reservations">
                <div v-if="reservation.expired">Verlopen</div>
                <div class="headline">Reservering</div>
                <span>{{reservation.expires}}</span><br>
                <span>{{reservation.artwork.name}}</span>
            </div>
        </v-card-title>
        <v-card-actions v-if="activeReservation" v-for="reservation in reservations" :key="reservation.id">
            <v-btn color="warning" :loading="updating" flat v-on:click="stopReservation(reservation)">Stop reservering
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import Reservation from '../store/orm/Reservation'


    export default {
        name: "UserSubscription",
        props: ['subscription'],
        data() {
            return {
                updating: false
            }
        },
        computed: {
            reservations() {
                return this.subscription.reservations.filter(reservation => {
                    return this.active
                })
            },

            activeReservation() {
                return this.reservations.length > 0
            }
        },
        methods: {
            stopReservation(reservation) {
                this.updating = true
                Reservation.dispatch('stopReservation', reservation)
                    .then(reponse => {
                        this.updating = false
                        this.$store.commit('setSuccess', 'reservering gestopt')
                    });
            }
        }
    }
</script>

<style scoped>
    .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
