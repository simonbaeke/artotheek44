<template>
    <app-content>
        <template slot="toolbar">
            <v-flex xs6>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        prepend-icon=""
                        label="Zoek lidkaart"
                        single-line
                        hide-details
                ></v-text-field>
            </v-flex>
            <v-spacer/>
            <create-existing-subscription-dialog/>
        </template>
        <template slot="text">
            <v-data-table
                    :rows-per-page-items="rowsPerPage"

                    :search="search"
                    :headers="headers"
                    :items="subscriptions">
                <template slot="items" slot-scope="props">

                    <subscription-list-row :subscription="props.item"/>

                </template>
            </v-data-table>
        </template>
    </app-content>
</template>

<script>
    import appContent from '../basis/content'
    import subscriptionListRow from './SubscriptionListRow'
    import Subscription from "@/store/orm/Subscription";
    import Expire from "@/store/orm/Expire";
    import createExistingSubscriptionDialog from '../dialog/CreateExistingSubscriptionDialog'

    export default {
        name: "SubscriptionList",
        data() {
            return {
                headers: [
                    {
                        text: 'Lidkaartnummer',
                        value: 'number'
                    },
                    {
                        text: 'Gebruiker',
                        value: 'user.fullname'
                    },
                    {
                        text: 'Geldig tot',
                        value: 'expire.date'
                    },
                    {
                        text:"Verwijderen",
                        sortable:false
                    }
                ],
                search: "",
                rowsPerPage: [10]
            }
        },
        computed: {
            subscriptions() {
                return Subscription.query().with('user').get()
                    .map(subscription => {
                        return {
                            id: subscription.id,
                            user: subscription.user,
                            number: subscription.number,
                            expire: Expire.query().where('expirable_type', 'Subscription').where('expirable_id', subscription.id).first(),
                            expired: subscription.expired

                        }
                    })
            }
        },
        components: {
            appContent,
            subscriptionListRow,
            createExistingSubscriptionDialog
        },
        mounted() {
            Subscription.dispatch('filter')
        }
    }
</script>

<style scoped>

</style>
