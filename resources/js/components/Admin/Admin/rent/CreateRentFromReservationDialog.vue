<template>
    <v-dialog v-model="dialog" persistent hide-overlay max-width="600px" xs12>
        <v-card>
            <v-card-title>
                <span class="headline">Nieuwe ontlening voor {{artwork.name}} </span>
            </v-card-title>
            <v-card-text class="grey--text">Reservering door {{user.firstname}} omzetten in ontlening</v-card-text>
            <v-card-text>
                <v-container>
                    <expire-date-picker
                            :max-date="subscription.expires"
                            :start-date="date"
                            v-on:datechange="expires=$event"
                    />
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn :loading="saving" flat @click.native="saveRent">Save</v-btn>
                <v-btn flat @click.native="$emit('close')">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<script>
    import Reservation from '../../../store/orm/Reservation'
    import Subscription from "@/store/orm/Subscription";
    import Artwork from "@/store/orm/Artwork";
    import User from "@/store/orm/User";
    import expireDatePicker from '../date/ExpireDatePicker'

    export default {
        name: "CreateRentFromReservation",
        props:
            {
                reservationId: {
                    type: Number,
                    required: true
                },
                dialog: {
                    type: Boolean,
                    required: true
                }
            }
        ,
        data() {
            return {
                saving: false,
                menu: false,
                date: new Date().toISOString().substr(0, 10),
                expires: new Date().toISOString().substr(0, 10),
            }
        },
        computed: {
            reservation() {
                return Reservation.find(this.reservationId)
            },

            subscription() {
                return Subscription.find(this.reservation.subscription_id)
            },
            artwork() {
                return Artwork.find(this.reservation.artwork_id)
            },
            user() {
                return User.find(this.subscription.user_id)
            }
        },

        methods: {
            saveRent() {
                this.saving = true;

                if (!this.subscription.confirmed){
                    alert('subscription not confirmed')
                    this.saving = false
                    this.$emit('close')
                    return
                }

                Reservation.dispatch('stopReservation', this.reservation)
                    .then(response => {
                        this.$store.dispatch('createRent', {
                            artwork_id: this.reservation.artwork_id,
                            subscription_id: this.reservation.subscription_id,
                            expires: this.expires,
                            returned_at: null
                        }).then(response => {
                            this.$emit('close');
                            this.saving = false;
                        }).catch(error => {
                            this.saving = false;
                            //this.$store.commit('setError',error)
                        })
                    })
                    .catch(error => {

                    })
            }
        },
        components: {
            expireDatePicker
        }
    }
</script>

<style scoped>

</style>
