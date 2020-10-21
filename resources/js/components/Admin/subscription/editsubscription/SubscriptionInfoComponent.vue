<template>
    <div>
        <v-simple-table>
            <template v-slot:default>
                <thead>
                <tr>
                    <th class="text-left">Lidkaartnummer</th>
                    <th class="text-left">Gestart op</th>
                    <th class="text-left">Verloopt op</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{subscription.number}}</td>
                    <td>{{subscription.started_at}}</td>
                    <td>{{ subscription.expires_at }}</td>

                    <td class="text-right">
                        <v-btn
                                v-if="subscription.confirmed == true"
                                @click="renewDialog=true"
                                outlined
                        >Lidkaart verlengen
                        </v-btn>
                        <v-btn @click="$emit('showEdit')" outlined>Lidkaart wijzigen</v-btn>
                        <v-btn @click="cancelDialog = true" outlined>Lidkaart schrappen</v-btn>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>

        <confirm-dialog
                :dialog="confirmDialog"
                :confirming="confirming"
                v-on:confirm="confirmSubscription"
                v-on:cancel="confirmDialog=false"
        >
            <template slot="text">
                <span>
                    lidkaart bevestigen
                </span>
            </template>
        </confirm-dialog>

        <confirm-dialog
                :dialog="renewDialog"
                :confirming="renewing"
                v-on:confirm="renewSubscription"
                v-on:cancel="renewDialog=false"
        >
            <template slot="text">
                <span class="headline">Lidkaart verlengen</span>
            </template>
        </confirm-dialog>

        <confirm-dialog
                :dialog="cancelDialog"
                :confirming="canceling"
                v-on:confirm="cancelSubscription"
                v-on:cancel="cancelDialog=false"
        >
            <template slot="text">
                <span class="headline">Lidkaart schrappen</span>
            </template>
        </confirm-dialog>
    </div>

</template>

<script>
    import Subscription from '../../../../store/orm/Subscription'
    import Expire from '../../../../store/orm/Expire'
    import Confirmed from '../../../../store/orm/Confirmed'
    import confirmDialog from '../../dialog/ConfirmDialog'
    import {EventBus} from "../../../../Event";

    export default {
        name: "SubscriptionInfoComponent",
        props: {
            subscription: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                confirmDialog: false,
                confirming: false,
                renewDialog: false,
                renewing: false,
                cancelDialog: false,
                canceling: false
            }
        },
        methods: {
            confirmSubscription() {
                this.confirming = true
                Confirmed.dispatch('create', {
                    subscription_id: this.subscription.id
                })
                    .then(response => {
                        this.confirming = false
                        this.confirmDialog = false
                        this.$router.push({name: 'userdetail', params: {id: response.data.data.user.id, tab: 2}})
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Abonnement is geldig',
                            type: 'success'
                        })
                    })
                    .catch(error => {
                        this.confirming = false
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Fout: ' + error,
                            type: 'error'
                        })
                    })
            },

            renewSubscription() {

                this.renewing = true
                Expire.dispatch('create', {
                    expirable_id: this.subscription.id,
                    expirable_type: 'Subscription',
                    user_id: this.subscription.user.id,
                }).then(response => {
                    this.$emit('renewed')

                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Lidkaart verlengd tot ' + response.data.data.date
                    })
                    Subscription.dispatch('fetchSubscriptionById', response.data.data.expirable_id)
                        .then(response => {
                            this.renewDialog = false
                            this.renewing = false
                            this.$router.push({name: 'userdetail', params: {id: response.data.data.user_id, tab: 2}})

                        })


                }).catch((error) => {
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Fout: lidkaart niet verlengd ' + error,
                        type: 'error'
                    })
                    this.renewDialog = false
                    this.renewing = false
                })
            },
            cancelSubscription() {
                this.canceling = true
                axios.post('/api/subscriptions/' + this.subscription.id, {
                    active: false,
                    _method:'PUT'
                })
                    .then(response => {
                        this.canceling = false
                        this.cancelDialog = false
                        Subscription.delete(response.data.data.id)
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Lidkaart geschrapt ',
                            type: 'success'
                        })
                    })
                    .catch(error => {

                        let errormessage = ""
                        if (error.response.data.hasOwnProperty('message')){
                            errormessage = error.response.data.message
                        }

                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Lidkaart niet geschrapt ' + errormessage,
                            type: 'error'
                        })
                        this.canceling = false
                        this.cancelDialog = false
                    })
            }
        },
        components: {
            confirmDialog
        }
    }
</script>

<style scoped>

</style>
