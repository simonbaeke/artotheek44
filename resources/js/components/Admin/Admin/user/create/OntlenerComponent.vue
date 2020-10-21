<template>
    <v-card flat>
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
                        <v-flex xs12 md6>
                            <v-text-field

                                    v-on:keydown="form.clearError('phone')"
                                    :error-messages="form.error('phone','Telefoonnummer')"
                                    :error="form.hasError('phone')"
                                    v-model="form.phone"
                                    label="Telefoonnummer">
                            </v-text-field>
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
                    flat

                    v-on:click="createUser">Opslaan
            </v-btn>
            <v-btn flat v-on:click="$router.push({name:'userlist'})">Terug</v-btn>

        </v-card-actions>
    </v-card>
</template>

<script>
    import User from '../../../../store/orm/User'
    import {Form} from "@/Form";

    export default {
        name: "OntlenerComponent",
        data() {
            return {
                form: new Form({
                    firstname: "",
                    lastname: "",
                    email: "",
                    phone: "",
                    memberid: "",
                    street: "",
                    number: "",
                    zip: "",
                    city: "",
                    notify: false
                })
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
                    memberid: this.form.memberid,
                    street: this.form.street,
                    number: this.form.number,
                    zip: this.form.zip,
                    city: this.form.city,
                    roles: roles,
                    notify: this.form.notify
                }
            }
        },
        methods: {
            createUser() {
                User.dispatch('create', this.post).then((response) => {
                    this.$router.push({name: 'userdetail', params: {id: response.data.data.id}})
                    this.form.clearErrors();
                }).catch(error => {
                    this.form.setErrors(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>
