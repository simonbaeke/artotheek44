<template>
    <div>
        <v-card-text>
            <v-form>
                <v-container>
                    <v-layout row wrap>
                        <v-flex xs12 md6>
                            <v-text-field
                                    v-on:keydown="form.clearError('firstname')"
                                    :error-messages="form.error('firstname','Voornaam')"
                                    :error="form.hasError('firstname')"
                                    v-model="form.firstname"
                                    label="voornaam">
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-text-field

                                    v-on:keydown="form.clearError('lastname')"
                                    :error-messages="form.error('lastname','Familienaam')"
                                    :error="form.hasError('lastname')"
                                    v-model="form.lastname"
                                    label="familienaam">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md6>
                            <v-text-field
                                    v-on:keydown="form.clearError('email')"

                                    :error-messages="form.error('email','Email')"
                                    :error="form.hasError('email')"
                                    v-model="form.email"
                                    label="Email">
                            </v-text-field>
                        </v-flex>
                        <v-flex md6 class="hidden-sm-and-down"></v-flex>


                        <v-flex xs12 v-for="phonenumber,index in phoneNumbers" :key="index">
                            <v-layout row wrap>
                                <v-flex xs4 md2 class="pr-2">
                                    <v-select
                                            :items="phoneTypes"
                                            item-text="name"
                                            item-value="id"
                                            label="Telefoon of GSM"
                                            v-model="phoneNumbers[index].type"
                                    ></v-select>

                                </v-flex>
                                <v-flex xs8 md4>
                                    <v-text-field
                                            type="tel"
                                            v-on:keydown="form.clearError('phone')"
                                            :error-messages="form.error('phone','Telefoonnummer')"
                                            :error="form.hasError('phone')"
                                            v-model="phoneNumbers[index].number"
                                            label="Telefoonnummer">
                                    </v-text-field>
                                </v-flex>
                                <v-flex md6 class="hidden-sm-and-down"></v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12 md6>
                            <v-btn text v-on:click="addPhoneNumber">Extra telefoonnummer toevoegen</v-btn>
                        </v-flex>
                        <v-flex xs12 md10>
                            <v-text-field

                                    v-on:keydown="form.clearError('street')"
                                    :error-messages="form.error('street','Straat')"
                                    :error="form.hasError('street')"
                                    v-model="form.street"
                                    label="Straat">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md2>
                            <v-text-field

                                    v-on:keydown="form.clearError('number')"
                                    :error-messages="form.error('number','Huisnummer')"
                                    :error="form.hasError('number')"
                                    v-model="form.number"
                                    label="Huisnummer">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md10>
                            <v-text-field

                                    v-on:keydown="form.clearError('city')"
                                    :error-messages="form.error('city','Stad')"
                                    :error="form.hasError('city')"
                                    v-model="form.city"
                                    label="Stad">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md2>
                            <v-text-field

                                    v-on:keydown="form.clearError('zip')"
                                    :error-messages="form.error('zip','Postcode')"
                                    :error="form.hasError('zip')"
                                    v-model="form.zip"
                                    label="Postcode">
                            </v-text-field>
                        </v-flex>

                    </v-layout>
                </v-container>
                <v-checkbox v-model="form.notify" label="Verwittig nieuw lid via email"/>
            </v-form>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
            <v-btn
                    text
                    :loading="saving"
                    v-on:click="createUser">Opslaan
            </v-btn>
            <v-btn text v-on:click="$router.push({name:back})">Terug</v-btn>

        </v-card-actions>
    </div>
</template>

<script>
    import User from '../../../../store/orm/User'
    import {Form} from "../../../../Form";
    import {EventBus} from "../../../../Event";

    export default {
        name: "OntlenerComponent",
        props: {
            ontlener: {
                required: false,
                default: true
            },
            vrijwilliger: {
                required: false,
                default: false
            },
            back: {
                default: 'userlist'
            }
        },
        data() {
            return {
                form: new Form({
                    firstname: "",
                    lastname: "",
                    email: "",
                    phone: "",
                    street: "",
                    number: "",
                    zip: "",
                    city: "",
                    notify: false,

                }), phoneNumbers: [{number: "", type: 1}],
                phoneTypes: [{id: 1, name: 'Telefoon'}, {id: 2, name: 'Gsm'}],
                saving: false
            }
        },
        computed: {
            post() {
                var roles = ['ontlener'];
                if (this.admin) {
                    roles.push('admin')
                }

                return {
                    firstname: this.form.firstname,
                    lastname: this.form.lastname,
                    email: this.form.email,
                    phone: this.form.phone,
                    street: this.form.street,
                    number: this.form.number,
                    zip: this.form.zip,
                    city: this.form.city,
                    roles: roles,
                    notify: this.form.notify,
                    phonenumbers: this.phoneNumbers
                }
            }
        },
        methods: {
            createUser() {
                this.saving = true
                User.dispatch('create', this.post).then((response) => {

                    this.saving = false

                    this.$router.push({name: this.back})


                    this.form.clearErrors();
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Nieuwe gebruiker aangemaakt',
                        type: 'success'
                    })

                    EventBus.$emit('vrijwilliger aangemaakt', response.data.data.id)
                }).catch(error => {
                    this.saving = false
                    console.log(error)
                    this.form.setErrors(error);
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'gebruiker niet aangemaakt ' + error,
                        type: 'error'
                    })

                })
            },

            addPhoneNumber() {
                this.phoneNumbers.push({number: "", type: 1})
            }
        }
    }
</script>

<style scoped>

</style>
