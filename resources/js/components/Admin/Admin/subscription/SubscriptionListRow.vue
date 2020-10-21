<template>
    <tr v-bind:class="{verlopen:expired}">
        <td v-on:click="editNumberDialog=true">{{subscription.number}}</td>
        <td>{{subscription.user.fullname}}</td>

        <expire-dialog :expire="subscription.expire"/>
        <td>
            <v-btn flat small fab v-on:click="deleteDialog=true"> <v-icon small>delete_outline</v-icon></v-btn>

        </td>

        <edit-subscription-number-dialog
                :subscription="subscription"
                :dialog="editNumberDialog"
                v-on:close="close"
        />

        <confirm-dialog
                :dialog="deleteDialog"
                :confirming="deleting"
                v-on:confirm="deleteSubscription"
                v-on:cancel="deleteDialog=false"
        >
            <template slot="text">Verwijder Lidkaart?</template>
        </confirm-dialog>
    </tr>
</template>

<script>

    import expireDialog from '../dialog/ExpireDialog'
    import editSubscriptionNumberDialog from './EditSubscriptionNumberDialog'
    import Subscription from "@/store/orm/Subscription";
    import confirmDialog from '../dialog/ConfirmDialog'

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
                deleting:false
            }
        },
        computed: {
            expired() {
                return Date.parse(this.subscription.expire.date) < new Date()

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
            deleteSubscription() {
                this.deleting=true
                Subscription.dispatch('destroy', {
                    id: this.subscription.id
                }).then(response=>{
                    this.deleting = false
                })
            }
        },
        components: {
            expireDialog,
            editSubscriptionNumberDialog,
            confirmDialog
        }
    }
</script>

<style scoped>
    .verlopen {
        color: red
    }
</style>
