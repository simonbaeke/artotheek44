<template>
    <v-dialog v-model="dialog" persistent hide-overlay width="50%" transition="scale-transition" xs6>

        <template slot="activator">
            <v-btn>Lidkaart aanpassen</v-btn>
        </template>
        <v-card>
            <v-card-title>
                Abonnement wijzigen
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-flex md5>
                        <edit-subscription-date-dialog :expire="expire"/>
                    </v-flex>
                    <v-flex md5>
                        <v-text-field
                                label="abonnementsnummer"
                                v-model="number"
                                type="number"
                                step="1"
                                min="0"
                        />
                    </v-flex>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <!-- <v-btn :loading="updating" flat @click.native="updateSubscription">Bevestigen</v-btn>-->

                <v-btn :disabled="updating" flat @click="dialog=false">Sluiten</v-btn>
                <v-btn :disabled="updating" flat @click="update">OPslaan</v-btn>
                <v-btn flat @click="deleteSubscription">Verwijder lidkaart</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import editSubscriptionDateDialog from './EditSubscriptionDateDialog'
    import Subscription from "../../../store/orm/Subscription";

    export default {
        name: "EditSubscriptionDialog",
        props: {
            subscription: {
                required: true
            },
            expire: {
                required: true
            }
        },

        data() {
            return {
                dialog: false,
                picker: new Date(Date.parse(this.expire.date)).toISOString().substr(0, 10),
                number: this.subscription.number,
                updating: false
            }
        },
        computed: {
            datestring() {
                return (new Date(this.subscription.expires)).toLocaleDateString()
            }
        },
        components: {
            editSubscriptionDateDialog,

        },
        methods: {

            update() {
                this.updating = true
                axios.put('api/subscriptions/' + this.subscription.id, {
                    number: this.number
                }).then(response => {
                    Subscription.insertOrUpdate({data: response.data.data})
                    this.dialog = false
                }).finally(() => {
                    this.updating = false
                })
            },
            deleteSubscription() {
                Subscription.dispatch('destroy', {id: this.subscription.id}).then(response => {
                    this.dialog = false
                }).catch(error => {
                    this.dialog = false
                })
            }
        }
    }
</script>

<style scoped>

</style>
