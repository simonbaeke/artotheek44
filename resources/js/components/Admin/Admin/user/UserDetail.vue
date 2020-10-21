<template>
    <app-content>
        <template slot="toolbar">
            <v-toolbar-title>
                {{user.firstname}} {{user.lastname}}
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn
                    v-on:click="createSubscriptionDialog = true"
                    flat
                    class="mb-2"
            >Nieuwe lidkaart aanpaken
            </v-btn>
        </template>


        <template slot="text">
            <v-tabs
                    v-model="selectedComponent"

                    slider-color="lime"
            >
                <v-tab
                        v-for="tab in tabs"
                        :key="tab.tab"
                        ripple
                >
                    {{ tab.tab }}

                </v-tab>
                <v-tab-item
                        v-for="tab in tabs"

                        :key="tab.component"
                >

                    <component
                            :is="tab.component"
                            :user="user"
                            :address="address"
                            :loading="loading"
                            v-on:cancel="showUserInfo"
                            v-on:edit="selectedComponent = 'userEdit'"/>
                </v-tab-item>
            </v-tabs>
            <confirm-dialog :dialog="createSubscriptionDialog"
                            :confirming="creating"
                            v-on:confirm="createSubscription"
                            v-on:cancel="createSubscriptionDialog=false">
                <template slot="text">Nieuwe lidkaart aanmaken
                    <v-checkbox label="Ook order aanmaken" v-model="createOrder"/>
                    <span class="blue--text">
                        <v-icon small class="blue--text mr-1">info</v-icon>
                            Uitzetten indien een lidkaart ingegeven wordt die al bestaat
                    </span>
                    <v-text-field type="number" v-if="!createOrder" v-model="subscriptionnumber"
                                  label="Lidkaartnummer"/>
                </template>
            </confirm-dialog>
        </template>


    </app-content>
</template>

<script>
    import loadingIndicator from '../../LoadingIndicator';
    import userInfo from './UserInfo.vue'
    import userOrders from './UserOrders'
    import userSubscriptions from './UserSubscriptions.vue'
    import User from '../../../store/orm/User'
    import Subscription from '../../../store/orm/Subscription'
    import Order from '../../../store/orm/Order'
    import Invoice from "@/store/orm/Invoice";
    import {EventBus} from "@/Event";
    import appContent from '../basis/content'
    import confirmDialog from '../dialog/ConfirmDialog'

    export default {
        name: "UserDetail",

        data() {
            return {
                selectedComponent: 'userSubscriptions',
                dialog: false,
                creating: false,
                loading: false,
                address: {
                    street: "",
                    number: "",
                    zip: "",
                    city: ''
                },
                active: '',
                createSubscriptionDialog: false,
                creating: false,
                createOrder: true,
                subscriptionnumber: null
            }
        },
        computed: {
            user() {
                let id = this.$route.params.id
                //indien null: load user from api
                return User.query().where('id', id).with('subscriptions.*').first()
            },
            pendingOrders() {
                //wanneer juist geladen , is invoice nog niet geladen dus invoice new niet gekend

                return Order.query().where('user_id', this.$route.params.id)
                    .whereHas('invoice', query => {
                        query.where('confirmed', false)
                    }).all()
            },
            tabs() {
                return [
                    {tab: 'Lidkaarten', component: 'userSubscriptions'},
                    {tab: 'Gegevens', component: 'userInfo'},
                    {tab: 'Bestelling', component: 'userOrders'}
                ]
            }

        },

        watch: {
            createOrder() {
                if (this.createOrder) {
                    this.subscriptionnumber = null
                }
            }
            ,
            createSubscriptionDialog() {
                if (!this.createSubscriptionDialog) {
                    this.subscriptionnumber = null
                }
            }
        },
        methods: {
            isSelectedComponent(component) {
                if (this.selectedComponent == component) {
                    return true
                }
                return false;
            },

            createSubscription() {
                this.creating = true;
                Subscription.dispatch('createSubscription', {
                    user_id: this.user.id,
                    active: true,
                    createorder: this.createOrder,
                    number: this.subscriptionnumber
                })
                    .then(response => {
                        this.dialog = false;
                        this.creating = false;
                        this.selectedComponent = 2
                    })
            }, fetchAddress() {
                this.loading = true
                axios.get('api/addresses/' + this.user.id).then(response => {
                    this.address = response.data.data
                    this.loading = false
                }).catch(error => {
                    this.loading = false
                })
            },
            showUserInfo() {
                this.selectedComponent = 1
                this.fetchAddress()
            }
        },

        components: {
            loadingIndicator,
            userInfo,
            userSubscriptions,
            userOrders,
            appContent,
            confirmDialog

        },
        mounted() {
            Invoice.dispatch('fetchById', {id: this.user.id})


            this.fetchAddress()


        },
        created() {
            EventBus.$on('showorder', (event) => {
                this.selectedComponent = 2
            })

        }
    }
</script>

<style scoped>
</style>
