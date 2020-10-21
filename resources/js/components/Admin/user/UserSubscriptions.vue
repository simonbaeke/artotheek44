<template>
    <v-container>
                    <span class="blue--text">
                        <v-icon small class="blue--text mr-1">info</v-icon>
                        Klik op een rij van de tabel om de lidkaart wijzigen of een ontlening toe te voegen
                    </span>
        <v-data-table
                :headers="headers"
                :items="subscriptions"
                hide-default-footer

        >
            <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

            <template v-slot:body="{ items }">

                <user-subscription-row
                        v-for="(item,index) in items" :key="item.name"
                        :subscription="item"
                        @click="expanded=index"
                >
                </user-subscription-row>
            </template>


            <!--            <template slot="expand" slot-scope="props">

                        </template>-->
        </v-data-table>


        <!-- <v-dialog v-model="edit" persistent max-width="900">
             <v-card>
                 <v-card-title>

                 </v-card-title>
                 <v-card-text>
                     <edit-subscription-component v-if="expanded!=-1"
                             :subscription="this.subscriptions[expanded]"
                             v-on:renewed="showorder"
                             v-on:rentcreated="showorder"
                     />
                 </v-card-text>
                 <v-card-actions>
                     <v-btn text @click="expanded=-1">sluit</v-btn>
                 </v-card-actions>
             </v-card>

         </v-dialog>-->
    </v-container>

</template>

<script>
    import userSubscriptionRow from '../user/UserSubscriptionRow'
    import editSubscriptionComponent from '../subscription/EditSubscriptionDialog'
    import subscriptionDialog from '../subscription/SubscriptionDialog'
    import Subscription from "../../../store/orm/Subscription";
    import Expire from "../../../store/orm/Expire";
    import {EventBus} from "../../../Event";

    export default {
        name: "UserSubscriptions",
        props: ['user', 'loading'],
        data() {
            return {
                expanded: -1,

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
                return Subscription.query().where('user_id', this.user.id)
                    .with('expire')
                    .with('user')
                    .with('rents')
                    .get()

            },
            edit() {
                return this.expanded != -1
            }
        },
        components: {
            userSubscriptionRow,
            editSubscriptionComponent,
            subscriptionDialog
        },
        methods: {
            showorder() {
                EventBus.$emit('showorder')
            }
        },
        mounted() {
            Subscription.dispatch('fetch', {user: this.user.id})
                .then(response => {
                    console.log(response)
                })
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
