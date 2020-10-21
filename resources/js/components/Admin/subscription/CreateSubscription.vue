<template>
    <div>
        <v-btn
                v-on:click="showNewSubscription"
                text
                class="mb-2"
        >Nieuwe lidkaart aanmaken
        </v-btn>
        <v-btn
                v-on:click="showExistingSubscription"
                text
                class="mb-2"
        >Bestaande lidkaart ingeven
        </v-btn>


        <confirm-dialog :dialog="createSubscriptionDialog"
                        :confirming="creating"
                        v-on:confirm="createSubscription"
                        v-on:cancel="close">
            <template slot="text">{{form.existing?'Bestaande lidkaart ingeven':'Nieuwe lidkaart aanmaken'}}


                <v-layout row wrap>
                    <v-flex xs12 sm12>
                        <v-text-field v-if="user_id>0"
                                      readonly
                                      v-model="user.name"
                                      label="Ontlener"
                                      prepend-icon="person"
                        ></v-text-field>
                        <v-autocomplete
                                v-else
                                v-model="form.user_id"
                                :items="users"
                                prepend-icon="person"
                                item-text="name"
                                item-value="id"
                                label="Selecteer ontlener"
                        >
                        </v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm12>
                        <v-text-field type="number"
                                      prepend-icon="payment"

                                      v-model="form.number"
                                      @mousedown:stop="form.clearError('number')"
                                      :error="form.hasError('number')"
                                      :error-messages="form.error('number')"
                                      label="Lidkaartnummer"/>
                    </v-flex>


                    <v-flex xs12 sm12>
                        <v-menu
                                v-model="started_atpicker"
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
                                        v-model="form.started_at"
                                        label="Startdatum van de lidkaart"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="form.started_at"
                                           v-on:input="started_atpicker = false"></v-date-picker>
                        </v-menu>
                    </v-flex>

                    <v-flex xs12 sm12>
                        <v-menu
                                v-model="expires_atpicker"
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
                                        v-model="form.expires_at"
                                        label="Einddatum van de lidkaart"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="form.expires_at"
                                           v-on:input="expires_atpicker = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                </v-layout>

            </template>
        </confirm-dialog>

    </div>
</template>

<script>
    import {Form} from "../../../Form";
    import Subscription from '../../../store/orm/Subscription'
    import User from '../../../store/orm/User'
    import confirmDialog from '../dialog/ConfirmDialog'
    import {EventBus} from '../../../Event'


    export default {
        name: "CreateSubscription",
        props: {
            user_id: {
                default: null
            }
        },
        data() {
            return {
                createSubscriptionDialog: false,
                creating: false,
                date: new Date(Date.now()).toISOString().substr(0, 10),
                expires_atpicker: false,
                started_atpicker: false,
                form: new Form({
                    number: "",
                    existing: false,
                    user_id: '',
                    started_at: '',
                    expires_at: '',
                    active:true,
                    confirmed:true
                }),
            }
        },
        watch: {
            createSubscriptionDialog() {
                if (this.createSubscriptionDialog && this.user_id != null) {
                    this.form.user_id = this.user_id
                }

                if (this.createSubscriptionDialog) {
                    this.setForm()


                    axios.get('/api/subscriptions/number/get')
                        .then(response => {
                            this.form.number = response.data.number
                        })
                }
            }
        },
        methods: {
            getNextYear(){
                let date = (new Date())
                return date.setFullYear(date.getFullYear() + 1)
            },
            createSubscription() {
                this.creating = true;

                Subscription.dispatch('createSubscription', this.form.data())
                    .then(response => {
                        this.createSubscriptionDialog = false;
                        this.creating = false;

                        this.setForm()


                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Nieuw abonnement aangemaakt'
                        })

                        if (!this.form.existing){
                            this.$emit('created',this.form.user_id)

                        }
                    })
                    .catch(error => {
                        this.creating = false
                        let message = error.request.data.message
                        if (error.request.status == 422) {

                            this.form.setErrors((JSON.parse(error.request.response)).errors)

                        }
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Abonnement niet aangemaakt ' + message,
                            type: 'error'
                        })
                    })
                    .finally(() => {
                    })
            },
            showNewSubscription() {
                this.createSubscriptionDialog = true
                this.form.existing = false
            },
            showExistingSubscription() {
                this.createSubscriptionDialog = true
                this.form.existing = true
            },
            setForm(){
                let date = (new Date())
                date.setFullYear(date.getFullYear() + 1)

                this.form.started_at = new Date(Date.now()).toISOString().substr(0, 10)
                this.form.expires_at= date.toISOString().substr(0,10)
            },
            close(){
                this.createSubscriptionDialog = false
            }

        },
        computed: {
            users() {
                return User.query().all().map(user => {
                    return {
                        name: user.firstname + " " + user.lastname + " -- " + user.email,
                        id: user.id
                    }
                })
            },
            user() {
                if (this.user_id != null) {
                    let user = User.find(this.user_id)

                    if (user) {
                        return {
                            name: user.firstname + " " + user.lastname,
                            id: user.id
                        }
                    }

                    return {
                        name: "",
                        id: null
                    }
                }

                return {
                    name: "",
                    id: null
                }
            },
            year(){


                let date = (new Date())
                date.setFullYear(date.getFullYear() + 1)
                return date
            }
        },
        mounted() {
            User.dispatch('fetch', {role: 'ontlener', list: 'true'})

        },
        components: {
            confirmDialog: confirmDialog
        }
    }
</script>

<style scoped>

</style>
