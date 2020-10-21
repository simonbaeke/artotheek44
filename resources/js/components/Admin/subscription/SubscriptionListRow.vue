<template>
    <tr v-bind:class="{verlopen:expired}">

        <router-link tag="td" :to="{ name: 'subscriptiondetail', params: { id: subscription.id }}">
            {{subscription.number}}
        </router-link>

        <!-- //<td @click.stop="subscriptionDialog = true">{{subscription.number}}</td>-->
        <td
                v-if="subscription.user != null">{{subscription.user.firstname}} {{subscription.user.lastname}}
        </td>


        <td>
            {{subscription.expires_at}}
        </td>
        <td>
            <v-btn text small fab v-on:click="deleteDialog=true">
                <v-icon small>delete_outline</v-icon>
            </v-btn>
        </td>


        <confirm-dialog
                :dialog="deleteDialog"
                :confirming="deleting"
                v-on:confirm="deleteSubscription"
                v-on:cancel="closeDeleteDialog"
        >
            <template slot="text">Verwijder Lidkaart {{subscription.number}}?</template>
        </confirm-dialog>

    </tr>
</template>

<script>

    import Subscription from "../../../store/orm/Subscription";
    import confirmDialog from '../dialog/ConfirmDialog'
    import {EventBus} from "../../../Event";

    export default {
        name: "SubscriptionListRow",
        props: {
            subscription: {
                required: true
            }
        },
        data() {
            return {
                editNumberDialog: false,
                number: this.subscription.number,
                deleteDialog: false,
                deleting: false,
                subscriptionDialog: false
            }
        },
        computed: {
            expired() {
                if (this.subscription.expire != null) {
                    return Date.parse(this.subscription.expire.date) < new Date()
                }

                return null

            }
        },
        watch: {
            editNumberDialog() {
                if (this.editNumberDialog) {
                    this.number = this.subscription.number
                }
            }
        },
        methods: {
            close() {
                this.editNumberDialog = false
            },
            closeDeleteDialog() {
                this.deleting = false
                this.deleteDialog = false
            },
            deleteSubscription() {
                this.deleting = true
                Subscription.dispatch('destroy', {
                    id: this.subscription.id
                })
                    .then(() => {
                        EventBus.$emit('message',
                            {
                                component: 'notificationSnackbar',
                                message: 'Abonnement verwijderd',
                                type: 'success'
                            })
                    })
                    .catch(error => {
                        console.log(error.response)
                        EventBus.$emit('message',
                            {
                                component: 'notificationSnackbar',
                                message: "Abonnement niet verwijderd: " + error.response.data.message,
                                type: 'error'
                            })
                    })
                    .finally(response => {
                        this.closeDeleteDialog()
                    })
            }
        },
        components: {
            confirmDialog,
        }
    }
</script>

<style scoped>
    .verlopen {
        color: red
    }
</style>
