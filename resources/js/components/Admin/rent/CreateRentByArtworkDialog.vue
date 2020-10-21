<template>
    <v-dialog v-model="dialog.dialog" persistent hide-overlay max-width="600px" transition="dialog-bottom-transition"
              xs12>
        <v-card v-if="dialog.dialog">
            <v-card-title>
                <span class="headline">Nieuwe ontlening voor {{artwork.name}}</span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-layout row wrap>
                        <v-flex xs12 sm7 md7>
                            <v-autocomplete
                                    :items="users"
                                    item-text="fullname"
                                    item-value="id"
                                    label="Ontlener"
                                    v-model="dialog.form.user_id"

                            ></v-autocomplete>
                        </v-flex>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs12 sm7 md7 v-if="selectedUser!= null">
                            <v-autocomplete
                                    :items="subscriptions"
                                    item-text="expires"
                                    item-value="id"
                                    :label="subscriptionLabel"
                                    :error="subscriptionError"
                                    v-model="dialog.form.subscription_id"
                                    no-data-text="Geen beschikbare abonnementen"

                            ></v-autocomplete>

                        </v-flex>
                    </v-layout>

                    <v-layout row wrap v-if="selectedSubscription">
                        <v-flex xs12 sm12 md12>
                            <expire-date-picker
                                    :subscription="selectedSubscription"
                                    v-on:datechange="dialog.form.expires=$event"
                            />

                        </v-flex>
                    </v-layout>
                    <v-layout>
                        <v-flex>
                            <v-radio
                                    label="cash"
                            />
                            <v-radio
                                    label="Overschrijving"
                            />
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn text @click.native="dialog.close()">Close</v-btn>
                <store-rent-button
                        :rent="dialog.data()"
                        v-on:close="dialog.close()"
                        v-on:error="showError($event)"/>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import User from '../../../store/orm/User'
    import Subscription from '../../../store/orm/Subscription'
    import Artwork from '../../../store/orm/Artwork'
    import expireDatePicker from '../date/ExpireDatePicker'
    import storeRentButton from '../buttons/StoreRentButton'

    export default {
        name: "CreateRentByArtworkDialog",
        props: {
            dialog: {
                type: Object,
                required: true
            }
        },
        computed: {
            artwork() {
                return Artwork.find(this.dialog.form.artwork_id)
            },
            users() {
                return User.getters('users')
            },
            subscriptions() {

                if (this.selectedUser == null){
                    return []
                }
                return Subscription.query().where('user_id', this.selectedUser.id).get().filter(subscription => {
                    return subscription.active && subscription.confirmed && subscription.available
                })
            },

            selectedUser() {
                return User.find(this.dialog.form.user_id)
            },

            selectedSubscription() {
                return Subscription.find(this.dialog.form.subscription_id)
            },

            subscriptionLabel() {

                if (this.selectedUser != null && this.subscriptions.length > 0) {
                    return "Selecteer een abonnement"
                }

                return "Geen abonnement beschikbaar"
            },
            subscriptionError() {
                return !(this.selectedUser != null && this.subscriptions.length > 0)
            }
            ,
            maxRent() {
                if (this.dialog.form.subscription_id != null) {
                    return this.selectedSubscription.expires

                }
            }
        },

        watch: {
            selectedUser() {
                console.log(this.subscriptions.length)

                this.dialog.form.subscription_id = null



                if (this.subscriptions.length == 1) {
                    this.dialog.form.subscription_id = this.subscriptions[0].id
                }
            }
        },
        methods: {
            showError(e) {
                this.dialog.form.setErrors(e)
            }
        },
        components: {
            expireDatePicker,
            storeRentButton
        }
    }
</script>

<style scoped>

</style>
