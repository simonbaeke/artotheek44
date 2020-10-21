<template>
    <div>
        <v-card class="elevation-0">
            <v-card-title v-if="!subscription.confirmed">
                <span class="v-small-dialog red--text mt-2">Proefabonnement</span>
                <span class="v-small-dialog blue--text" v-if="!subscription.confirmed">
                    <v-icon class="blue--text" small>info</v-icon>
                    Er kan pas een kunstwerk ontleend worden, wanneer de lidkaart bevestigd is
                </span>
            </v-card-title>
            <v-card-text>
                <v-layout>
                    <v-flex xs-12>
                        <span class="headline">Info</span>
                    </v-flex>
                </v-layout>


                <component
                        v-on:showEdit="showEditSubscription"
                        v-on:cancel="cancelEditSubscription"
                        :subscription="subscription"
                        v-bind:is="currentTabComponent"/>
            </v-card-text>
        </v-card>
        <v-divider class="mb-3"/>


        <v-card class="mt-2">
            <v-card-text>
                <component
                        v-if="activeRent!=null"
                        :rent="activeRent"
                        v-bind:is="currentActiveRentComponent"
                        v-on:edit="showEditRent"
                        v-on:cancel="cancelEditRent"

                />

                <active-reservation-component
                        v-if="activeReservation!=null"
                        :reservation="activeReservation"
                />

                <create-rent-component
                        v-if="activeRent==null && activeReservation==null"
                        :subscription="subscription"
                />
            </v-card-text>
        </v-card>
    </div>

</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import Reservation from '../../../store/orm/Reservation'
    import Expire from '../../../store/orm/Expire'
    import activeRentInfoComponent from './active/activeRentInfoComponent'
    import activeRentEditComponent from './active/activeRentEditComponent'
    import activeReservationComponent from './active/activeReservationComponent'
    import createRentComponent from '../rent/CreateRentComponent'
    import subscriptionInfoComponent from './editsubscription/SubscriptionInfoComponent'
    import subscriptionEditComponent from './editsubscription/SubscriptionEditComponent'
    import subscriptionConfirmComponent from './editsubscription/SubscriptionConfirmComponent'

    export default {
        name: "SubscriptionTab",
        props: {
            subscription: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                currentTabComponent: 'subscriptionInfoComponent',
                currentActiveRentComponent: 'activeRentInfoComponent'
            }
        }
        ,
        computed: {
            activeRent() {
                let rent = Rent.query()
                    .where('returned', false)
                    .where('subscription_id', this.subscription.id)
                    .with('artwork')
                    .with('expire')
                    .first()

                if (rent != null) {
                    rent.expire = Expire.query()
                        .where('expirable_type', 'Rent')
                        .where('expirable_id', rent.id)
                        .first()
                }
                return rent
            },

            activeReservation() {
                let reservation = Reservation.query()
                    .where('active', true)
                    .where('subscription_id', this.subscription.id)
                    .where('expired', false)
                    .with('artwork').with('expire').first()

                if (reservation != null) {
                    reservation.expire = Expire.query().where('expirable_type', 'Reservation').where('expirable_id', reservation.id).first()

                }


                return reservation
            },
        },
        methods: {
            showEditSubscription() {
                this.currentTabComponent = "subscriptionEditComponent"
            },
            cancelEditSubscription() {
                if (this.subscription.confirmed) {
                    this.currentTabComponent = "subscriptionInfoComponent"

                }
                else {
                    this.currentTabComponent = "subscriptionConfirmComponent"
                }

            },
            showEditRent() {
                this.currentActiveRentComponent = "activeRentEditComponent"
            },
            cancelEditRent() {
                this.currentActiveRentComponent = "activeRentInfoComponent"

            }
        },
        components: {
            activeRentInfoComponent,
            activeRentEditComponent,
            createRentComponent,
            activeReservationComponent,
            subscriptionInfoComponent,
            subscriptionEditComponent,
            subscriptionConfirmComponent
        },
        mounted() {
            if (!this.subscription.confirmed) {
                this.currentTabComponent = 'subscriptionConfirmComponent'
            }
        }
    }
</script>

<style scoped>

</style>
