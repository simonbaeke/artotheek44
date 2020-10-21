<template>
    <v-card class="elevation-0">
        <v-card-title v-if="!subscription.confirmed">
            <span class="v-small-dialog red--text mt-2">Proefabonnement</span>
            <span class="v-small-dialog blue--text" v-if="!subscription.confirmed">
                    <v-icon class="blue--text" small>info</v-icon>
                    Er kan pas een kunstwerk ontleend worden, wanneer de lidkaart bevestigd is
                </span>
        </v-card-title>


        <v-card-text style="padding:0">
            <v-container grid-list-md>
                <v-layout wrap row justify-space-between>
                    <v-flex xs12 md4>
                        <span class="grey--text">Lidkaart</span>
                        <v-layout column wrap>
                            <v-flex md6>

                                <v-btn-toggle>
                                    <v-btn text outline v-if="subscription.confirmed" v-on:click="renewDialog=true">Lidkaart
                                        verlengen
                                    </v-btn>


                                    <v-btn text outline v-if="!subscription.confirmed" v-on:click="confirmDialog=true">Bevestig
                                        Lidkaart
                                    </v-btn>
                                </v-btn-toggle>

                                <span v-if="!subscription.confirmed" class="grey--text">Dit is een voorlopige lidkaart, hij moet bevestigd worden om een kunstwerk te huren</span>


                            </v-flex>

                        </v-layout>
                    </v-flex>

                    <create-rent-component
                            v-if="subscription.available"
                            :subscription="subscription"
                            v-on:rentcreated="rentcreated"
                    />

                    <edit-rent-dialog
                            v-if="activeRent"
                            :rent="activeRent"
                    />


                    <div v-if="activeReservation">
                        <span class="grey--text">Kunstwerk dat gereserveerd is ontlenen</span>
                        <v-layout>
                            <v-btn-toggle >
                                <v-btn outline v-on:click="rentReserveDialog=true">Ontleen</v-btn>
                                <v-btn outline>Stop reservering</v-btn>
                            </v-btn-toggle>
                        </v-layout>


                    </div>

                </v-layout>
            </v-container>
        </v-card-text>
        <confirm-dialog :dialog="renewDialog"
                        :confirming="renewing"
                        v-on:confirm="updateSubscription"
                        v-on:cancel="renewDialog=false">
            <template slot="text">Abonnement verlengen</template>
        </confirm-dialog>
        <confirm-dialog
                :dialog="confirmDialog"
                :confirming="confirming"
                v-on:confirm="confirmSubscription"
                v-on:cancel="confirmDialog=false"
        >
            <template slot="text">Abonnement bevestigen?</template>
        </confirm-dialog>
        <confirm-dialog
                :dialog="rentReserveDialog"
                :confirming="rentReserving"
                v-on:confirm="rentReservation"
                v-on:cancel="rentReserveDialog = false"
        >
            <template slot="text">Gereserveerd kunstwerk ontlenen?</template>
        </confirm-dialog>
    </v-card>

</template>

<script>
    import Subscription from '../../../store/orm/Subscription'
    import createRentComponent from '../rent/CreateRentComponent'
    import confirmDialog from '../dialog/ConfirmDialog'
    import editRentDialog from '../rent/EditRentDialog'
    import Expire from "../../../store/orm/Expire";
    import Rent from "../../../store/orm/Rent";
    import Reservation from "../../../store/orm/Reservation";
    import {EventBus} from "../../../Event";
    import Confirmed from "../../../store/orm/Confirmed";
    import editSubscriptionNumberDialog from './EditSubscriptionNumberDialog'

    export default {
        name: "EditSubscriptionComponent",
        props: ['subscription'],
        data() {
            return {
                renewDialog: false,
                renewing: false,
                confirming: false,
                confirmDialog: false,
                rentReserving: false,
                rentReserveDialog: false,

            }
        },
        methods: {
            updateSubscription() {

                this.renewing = true
                Expire.dispatch('create', {
                    expirable_id: this.subscription.id,
                    expirable_type: 'Subscription',
                    user_id: this.subscription.user_id,
                }).then(() => {
                    this.$emit('renewed')
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Lidkaart verlengd'
                    })
                    Subscription.dispatch('fetchSubscriptionById',this.subscription.id)
                        .then(()=>{
                            this.renewDialog = false
                            this.renewing = false
                        })



                }).catch((error) => {
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Fout: lidkaart niet verlengd ' + error,
                        type:'error'
                    })
                    this.renewDialog = false
                    this.renewing = false
                })
            },

            confirmSubscription() {
                this.confirming = true
                Confirmed.dispatch('create', {
                    subscription_id: this.subscription.id
                })
                    .then(response => {
                        this.confirming = false
                        this.confirmDialog = false
                        EventBus.$emit('showorder')
                    })
                    .catch(error => {
                        this.confirming = false
                        console.log(error)
                    })
            },
            rentReservation() {
                this.rentReserving = true
                Rent.dispatch('createRent', {
                    subscription_id: this.activeReservation.subscription_id,
                    artwork_id: this.activeReservation.artwork_id
                }).then(response => {

                    this.rentReserving = false
                    this.rentReserveDialog = false
                    Reservation.delete(this.activeReservation.id)
                    EventBus.$emit('showorder')

                }).catch(error => {

                })
            },
            rentcreated() {
                EventBus.$emit('showorder')
            }


        },
        computed: {
            date() {
                this.expire.date
            },
            activeRent() {
                return Rent.query()
                    .where('returned', false)
                    .where('subscription_id', this.subscription.id)
                    .first()
            },
            activeReservation() {
                return Reservation.query()
                    .where('active', true)
                    .where('expired', false)
                    .where('subscription_id', this.subscription.id)
                    .first()
            },
            expire() {
                return Expire.query()
                    .where('expirable_type', 'Subscription')
                    .where('expirable_id', this.subscription.id)
                    .first()
            }
        },
        components: {
            createRentComponent,
            editRentDialog,
            confirmDialog,
            editSubscriptionNumberDialog,
        }
    }
</script>

<style scoped>

</style>
