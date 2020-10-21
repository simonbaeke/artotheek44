<template>
    <app-content>
        <template slot="toolbar">
            <v-flex xs6>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        prepend-icon=""
                        label="Zoek lidkaart op naam of lidkaardnummer"
                        single-line
                        hide-details
                ></v-text-field>
            </v-flex>
            <v-spacer/>
            <create-subscription
                    v-on:created="showUserOrders"
            />
        </template>
        <template slot="text">
            <v-data-table
                    :search="search"
                    :headers="headers"
                    sort-by="number"

                    :items="subscriptions">

                <template v-slot:body="{ items }">
                    <tbody>

                    <subscription-list-row v-for="(item,index) in items" :key="index" :subscription=" item"/>

                    </tbody>
                </template>
            </v-data-table>
        </template>
    </app-content>
</template>

<script>
    import appContent from '../basis/content'
    import subscriptionListRow from './SubscriptionListRow'
    import createSubscription from './CreateSubscription'
    import Subscription from "../../../store/orm/Subscription";
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
                        text: "Verwijderen",
                        sortable: false
                    }
                ],
                search: "",
                rowsPerPage: [10]
            }
        },
        computed: {
            subscriptions() {
                return Subscription.query().with('user').get()
            }
        },
        methods: {
            showUserOrders(id){
                console.log(id)
                this.$router.push({ name: 'userdetail', params: { id } }) // -> /user/123

            }
        },
        components: {
            appContent,
            subscriptionListRow,
            createExistingSubscriptionDialog,
            createSubscription
        },
        mounted() {
            Subscription.dispatch('filter', {
                list: true
            })
        }
    }
</script>

<style scoped>

</style>
