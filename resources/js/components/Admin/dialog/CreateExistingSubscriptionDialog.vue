<template>
    <v-dialog v-model="dialog" width="500" persistent>
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" text>Bestaande lidkaart ingeven</v-btn>
        </template>
        <v-card>
            <v-card-text>
                <v-form>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-autocomplete
                                    :items="users"
                                    item-text="fullname"
                                    item-value="id"
                                    label="Gebruiker"
                                    v-model="form.user_id"
                                    :has-error="form.hasError('user_id')"
                                    :error-messages="form.error('user_id')"
                            ></v-autocomplete>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                    v-model="form.number"
                                    :error-messages="form.error('number')"
                                    label="Lidkaartnummer"
                            />
                        </v-flex>
                        <v-flex xs12>
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
                                <template slot="activator">
                                    <v-text-field
                                            v-model="form.date"
                                            label="Einddatum van de lidkaart"
                                            prepend-icon="event"
                                            readonly
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="form.date" @input="pickermenu = false"></v-date-picker>
                            </v-menu>
                        </v-flex>

                    </v-layout>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn :loading="creating" text v-on:click="save">Opslaan</v-btn>
                <v-btn :disable="creating" text v-on:click="close">Annuleren</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>

<script>
    import {Form} from "../../../Form";
    import User from "../../../store/orm/User";
    import Subscription from "../../../store/orm/Subscription";
    import {EventBus} from "../../../Event";

    export default {
        name: "CreateExistingSubscriptionDialog",
        data() {
            return {
                dialog: false,
                form: new Form({
                    user_id: "",
                    number: "",
                    date: new Date(Date.now()).toISOString().substr(0, 10),
                    createorder: false
                }),
                pickermenu: false,
                creating:false
            }
        },
        methods: {
            save() {
                this.creating=true
                Subscription.dispatch('createSubscription',
                    this.form.data()).then(response => {
                    this.close()

                }).catch(error => {
                    this.form.setErrors(JSON.parse(error.request.response).errors)
                    EventBus.$emit('message',
                        {
                            component: 'notificationSnackbar',
                            message: 'Fout bij aanmaken abonnement',
                            type: 'error'
                        })
                    this.creating=false
                })
            },
            close() {
                this.creating =false
                this.dialog = false
                this.form.reset()
            }
        },
        computed: {
            users() {
                return User.query().whereHas('roles', (query) => {
                    query.where('name', 'ontlener')
                }).get()
            }
        }
    }
</script>

<style scoped>

</style>
