<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" text>Bestaande ontlening ingeven</v-btn>

        </template>
        <v-card>
            <v-card-title>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-layout row wrap align-center>
                        <v-flex xs12 sm7 md12>
                            <v-autocomplete
                                    :items="artworks"
                                    item-text="fullname"
                                    item-value="id"
                                    label="kunstwerk"
                                    v-model="form.artwork_id"
                                    :error-messages="form.error('artwork_id','Kunstwerk')"

                            ></v-autocomplete>
                        </v-flex>

                        <v-flex xs12 sm7 md12>
                            <span class="blue--text"><v-icon class="blue--text">info</v-icon>Enkel beschikbare kunstwerken worden getoond</span>
                        </v-flex>
                        <v-flex xs12 sm7 md6>
                            <v-autocomplete
                                    :items="users"
                                    item-text="name"
                                    item-value="id"
                                    label="Ontlener"
                                    v-model="user_id"
                                    :error-messages="form.error('user_id','Gebruiker')"

                            ></v-autocomplete>
                        </v-flex>
                        <v-flex xs12 sm7 offset-md2 md4>
                            <v-autocomplete
                                    :items="subscriptions"
                                    item-text="number"
                                    item-value="id"
                                    label="Lidkaartnummer"
                                    v-model="form.subscription_id"
                                    :has-error="hasSubscriptionError"
                                    :error-messages="subscriptionError"
                                    :loading="loadSubscriptions"

                            ></v-autocomplete>
                        </v-flex>
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
                                            v-model="form.date"
                                            label="Startdatum van de huur"
                                            prepend-icon="event"
                                            readonly
                                            v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="form.date" v-on:input="pickermenu = false"></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm12>
                            <v-menu
                                    v-model="maxdatemenu"
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
                                            v-model="form.max_date"
                                            label="Einddatum van de huur"
                                            prepend-icon="event"
                                            readonly
                                            v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="form.max_date" v-on:input="maxdatemenu = false"></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-layout align-center>
                            <v-checkbox v-model="form.returned" label="Teruggebracht" hide-details
                                        class="shrink mr-2"></v-checkbox>
                        </v-layout>

                        <v-flex xs12 sm12 v-if="form.returned">
                            <v-menu
                                    v-model="returndatemenu"
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
                                            v-model="form.return_date"
                                            label="Datum kunstwerk teruggebracht"
                                            prepend-icon="event"
                                            readonly
                                            v-on="on"

                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="form.return_date"
                                               v-on:input="returndatemenu = false"></v-date-picker>
                            </v-menu>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn :loading="creating" text @click="save">Opslaan</v-btn>

                <v-btn :disabled="creating" text @click="close">Annuleren</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>

<script>
    import Artwork from '../../../store/orm/Artwork';
    import Subscription from "../../../store/orm/Subscription";
    import User from "../../../store/orm/User";
    import {Form} from "../../../Form";
    import Rent from "../../../store/orm/Rent";

    export default {
        name: "CreateExistingRentDialog",
        data() {
            return {
                dialog: false,
                form: new Form({
                    user_id: "",
                    subscription_id: "",
                    artwork_id: "",
                    date: new Date(Date.now()).toISOString().substr(0, 10),
                    return_date: this.calcReturnDate(),
                    max_date: this.calcReturnDate(),
                    returned: false,
                    notify: true
                }),
                pickermenu: false,
                returndatemenu: false,
                maxdatemenu: false,
                creating: false,
                user_id: "",
                loadSubscriptions: false
            }
        },
        computed: {
            artworks() {
                return Artwork.query().get()
            },
            subscriptions() {
                return Subscription.query().where('user_id', this.form.user_id).get()
            },
            users() {
                return User.query().whereHas('roles', (query) => {
                    query.where('name', 'ontlener')
                }).get().map(user => {
                    return {
                        id: user.id,
                        name: user.firstname + " " + user.lastname
                    }
                })
            },
            hasSubscriptionError() {
                return this.form.user_id != "" && this.subscriptions.length == 0 && this.loadSubscriptions == false || this.form.hasError('subscription_id')
            },
            subscriptionError() {
                if (this.hasSubscriptionError) {
                    return 'Geen beschikbare lidkaart gevonden'
                } else if (this.form.hasError('subscription_id')) {
                    return this.form.error('subscription_id', 'Lidkaart')
                }

                return ""
            }
        },
        watch: {
            user_id() {
                this.form.user_id = this.user_id
                if (this.form.user_id != "") {

                    this.loadSubscriptions = true
                    Subscription.dispatch('fetch', {user: this.form.user_id})
                        .finally(this.loadSubscriptions = false)

                }
            },
            dialog() {
                if (this.dialog) {
                    //fetch artworks
                    Artwork.dispatch('fetchArtworks')
                    User.dispatch('fetch', {role: 'ontlener', list: 'true'})
                }
            }
        },
        mounted() {
            //fetch artworks
            // Artwork.dispatch('fetchArtworks')
            //fetch free subscriptions

            //fetch users
        },
        methods: {
            save() {
                this.creating = true
                Rent.dispatch('createRent',
                    this.form.data()
                ).then(response => {
                    this.creating = false
                    this.close()
                }).catch(error => {
                    this.creating = false
                    this.form.setErrors(JSON.parse(error.request.response).errors)
                })
            },
            close() {
                this.form.reset()
                this.dialog = false;
            },
            calcReturnDate() {
                let date = new Date(Date.now())
                date.setMonth(date.getMonth() + 6)
                return date.toISOString().substr(0, 10)
            }
        }
    }
</script>

<style scoped>

</style>
