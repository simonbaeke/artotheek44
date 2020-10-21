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
                    <td>{{ subscription.expire.date }}</td>

                    <td class="text-right">
                        <v-btn
                                v-if="subscription.confirmed == false"
                                @click="confirmDialog=true"
                                outlined
                        >Lidkaart bevestigen</v-btn>
                        <v-btn @click="$emit('showEdit')" outlined>Lidkaart wijzigen</v-btn>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>

        <confirm-dialog

                :confirming="confirming"
                :dialog="confirmDialog"
                v-on:confirm="confirmSubscription"
                v-on:cancel="confirmDialog = false"
        >
            <template slot="text">Abonnement bevestigen?</template>
        </confirm-dialog>
    </div>
</template>

<script>
    import confirmDialog from '../../dialog/ConfirmDialog'
    import Subscription from '../../../../store/orm/Subscription'
    import Confirmed from '../../../../store/orm/Confirmed'

    export default {
        name: "SubscriptionConfirmComponent",
        props: {
            subscription:{
                required:true,
                type:Object
            }
        },
        data() {
            return {
                confirmDialog: false,
                confirming: false
            }
        },
    computed:{
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
                        EventBus.$emit('showorder')
                    })
                    .catch(error => {
                        this.confirming = false
                        console.log(error)
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
