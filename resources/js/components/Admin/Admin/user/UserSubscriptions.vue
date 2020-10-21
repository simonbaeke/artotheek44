<template>
    <v-container>
                    <span class="blue--text">
                        <v-icon small class="blue--text mr-1">info</v-icon>
                        Klik op een rij van de tabel om het abonnement wijzigen of om een ontlening toe te voegen
                    </span>
        <v-data-table
                :headers="headers"
                :items="subscriptions"
                hide-actions
                :rows-per-page-items="rowsPerPage"

        >
            <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

            <template slot="items" slot-scope="props">
                <user-subscription-row
                        :subscription="props.item"
                        @click="props.expanded = !props.expanded"
                        v-bind:class="{expanded:props.expanded}"
                />
            </template>
            <template slot="expand" slot-scope="props">
                <edit-subscription-component
                        class="expanded"
                        :subscription="props.item"
                        v-on:renewed="showorder"
                        v-on:rentcreated="showorder"
                />
            </template>
        </v-data-table>
    </v-container>

</template>

<script>
    import userSubscriptionRow from '../user/UserSubscriptionRow'
    import editSubscriptionComponent from '../subscription/EditSubscriptionComponent'
    import Subscription from "@/store/orm/Subscription";
    import {EventBus} from "@/Event";

    export default {
        name: "UserSubscriptions",
        props: ['user', 'loading'],
        data() {
            return {
                rowsPerPage: [10],
                headers: [
                    {
                        text: 'Lidkaartnummer',
                        sortable: true,
                        value: 'id'
                    },

                    {
                        text: 'Lidkaart geldig tot',
                        align: 'left',
                        sortable: false,
                        value: 'name'
                    },
                    {text: 'Situatie lidkaart', value: 'Huidig', sortable: false,},
                    {text: 'Kunstwerk', value: 'artwork', sortable: false,},
                    {text: 'Code', value: 'artwork.code', sortable: false,},

                    {text: 'Huur of reservering verloopt op', value: 'expires', sortable: false,},
                ]
            }
        },
        computed: {

            subscriptions() {
                return Subscription.query().where('user_id', this.user.id).get()
            }
        },
        components: {
            userSubscriptionRow,
            editSubscriptionComponent
        },
        methods: {
            showorder() {
                EventBus.$emit('showorder')
            }
        },
        mounted() {
            console.log('mounted')
            Subscription.dispatch('fetchSubscriptionsByUserId', this.user.id)
        }
    }
</script>

<style scoped>
    .v-input {
        flex: 0 0;
        margin-left: 2rem;
    }

    .expanded {
        background-color: rgba(238, 238, 238, .45);
    }
</style>
