<template>
    <app-content>
        <template slot="toolbar">
            <v-toolbar-title v-if="user != null">
                {{user.firstname}} {{user.lastname}}
            </v-toolbar-title>

            <v-spacer></v-spacer>

<!--            <v-btn
                    v-on:click="showNewSubscription"
                    text
                    class="mb-2"
            >Nieuwe lidkaart aanmaken
            </v-btn>
            <v-btn
                    v-on:click="showExistingSubscription"
                    text
                    class="mb-2"
            >Bestaande lidkaart aanmaken
            </v-btn>-->
            <create-subscription
                    :user_id="$route.params.id"
                    v-on:created="selectedComponent=2"
            />
        </template>


        <template v-if="user!=null" slot="text">
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
                            :loading="loading"
                            v-on:cancel="showUserInfo"
                            v-on:edit="selectedComponent = 'userEdit'"/>
                </v-tab-item>
            </v-tabs>
            <confirm-dialog :dialog="createSubscriptionDialog"
                            :confirming="creating"
                            v-on:confirm="createSubscription"
                            v-on:cancel="createSubscriptionDialog=false">
                <template slot="text">{{existing?'Bestaande lidkaart aanmaken':'Nieuwe lidkaart aanmeken'}}
                    <v-text-field type="number"
                                  v-if="existing"
                                  v-model="form.number"
                                    @mousedown:stop="form.clearError('number')"
                                  :error="form.hasError('number')"
                                  :error-messages="form.error('number')"
                                  label="Lidkaartnummer"/>

                    <v-flex xs12 sm12>
                        <v-menu
                                v-model="pickermenu"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        v-model="date"
                                        label="Einddatum van de lidkaart"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="date" v-on:input="pickermenu = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                </template>
            </confirm-dialog>

        </template>

        <template v-if="user==null" slot="text">
            <div class="text-xs-center">
                <v-progress-circular
                        indeterminate
                        color="primary"
                />
            </div>
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
    import Invoice from "../../../store/orm/Invoice";
    import {EventBus} from "../../../Event";
    import appContent from '../basis/content'
    import confirmDialog from '../dialog/ConfirmDialog'
    import {Form} from "../../../Form";
    import createSubscription from '../subscription/CreateSubscription'

    export default {
        name: "UserDetail",

        data() {
            return {
                selectedComponent: 1,
                dialog: false,
                creating: false,
                loading: false,
                active: '',
                createSubscriptionDialog: false,
                creating: false,
                createOrder: true,
                existing: false,
                date: new Date(Date.now()).toISOString().substr(0, 10),
                pickermenu: false,
                form: new Form({
                    'number': ''
                })
            }
        },
        computed: {
            user() {
                //indien null: load user from api
                let user = User.query().with('address').find(this.$route.params.id);

                //indien geen adres

                if (user && !user.address) {
                    user.address = {
                        street: "",
                        zip: "",
                        city: "",
                        number: ""
                    }
                }
                return user
                // return User.query().where('id', this.$route.params.id).with('subscriptions.*').first()
            }
            ,
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
                    {tab: 'Te betalen', component: 'userOrders'}
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
            },
            selectedComponent() {
                if (this.selectedComponent == 0) {
                    Subscription.dispatch('fetch', {user: this.user.id})
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

                let data = {
                    user_id: this.user.id,
                    active: true,
                    existing: this.existing,
                }

                if (this.existing) {
                    data.date = this.date
                    data.number = this.form.number
                }

                Subscription.dispatch('createSubscription', data)
                    .then(response => {
                        this.createSubscriptionDialog = false;
                        this.creating = false;
                        this.selectedComponent = 2
                        this.form.reset()

                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Nieuw abonnement aangemaakt'
                        })
                    })
                    .catch(error => {
                        this.creating = false
                        let message = (JSON.parse(error.request.response)).message
                        if (error.request.status == 422) {

                            this.form.setErrors((JSON.parse(error.request.response)).errors)

                        }
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Abonnement niet aangemaakt ' + message,
                            type: 'error'
                        })
                    })
                    .finally(()=>{
                    })
            },
            showUserInfo() {
                this.selectedComponent = 1
                this.fetchAddress()
            },
            showNewSubscription() {
                this.createSubscriptionDialog = true
                this.existing = false
            },
            showExistingSubscription() {
                this.createSubscriptionDialog = true
                this.existing = true
            }
        },

        components: {
            loadingIndicator,
            userInfo,
            userSubscriptions,
            userOrders,
            appContent,
            confirmDialog,
            createSubscription

        },
        mounted() {
            User.dispatch('fetchUser', this.$route.params.id)
            // Invoice.dispatch('fetchById', {id: this.$route.params.id})

            if (this.$route.params.hasOwnProperty("tab")) {
                this.selectedComponent = this.$route.params.tab
            }
        },

        created() {
            EventBus.$on('showorder', (event) => {
                this.selectedComponent = 2
                Invoice.dispatch('fetch', {
                    confirmed: false,
                    user: this.user.id
                })

            })


        }
    }
</script>

<style scoped>
</style>
