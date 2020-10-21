<template>
    <v-app>
        <v-container>
            <v-layout>
                <v-flex xs12 md6 offset-md3>
                    <v-card class="elevation-1">
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>Registreren</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn
                                    white
                                    icon
                                    small
                                    v-on:click.prevent="onCancel"
                            >
                                <v-icon small>close</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-form method="post" action="/register" ref="form">
                                <input type="hidden" name="_token" v-model="token">
                                <v-text-field
                                        name="firstname"
                                        v-model="form.firstname"
                                        label="Voornaam"
                                        type="text"
                                        :error="form.hasError('firstname')"
                                        :error-messages="form.error('firstname','Voornaam')"
                                        v-on:focus="form.clearError('firstname')"
                                />
                                <v-text-field
                                        v-model="form.lastname"
                                        name="lastname"
                                        label="Naam"
                                        type="text"
                                        :error="form.hasError('lastname')"
                                        :error-messages="form.error('lastname','Familienaam')"
                                        v-on:focus="form.clearError('lastname')"
                                        required/>
                                <v-text-field v-model="form.email"
                                              name="email"
                                              label="Email"
                                              type="text"
                                              :error="form.hasError('email')"
                                              :error-messages="form.error('email','Emailadres')"
                                              v-on:focus="form.clearError('email')"
                                              required/>

                                <v-text-field v-model="form.phone"
                                              name="phone"
                                              label="Telefoonnummer"
                                              type="text"
                                              :error="form.hasError('phone')"
                                              :error-messages="form.error('phone','Telefoonnummer')"
                                              v-on:focus="form.clearError('phone')"
                                              required/>

                                <v-text-field
                                        name="password"
                                        v-model="form.password"
                                        label="Paswoord"
                                        type="password"
                                        :error="form.hasError('password')"
                                        :error-messages="form.error('password','Wachtwoord')"
                                        required
                                ></v-text-field>

                                <v-text-field
                                        name="password"
                                        v-model="form.password_confirmation"
                                        label="Bevestig Paswoord"
                                        type="password"
                                        required
                                        :error="form.hasError('password_confirmation')"
                                        :error-messages="form.error('password_confirmation')"
                                ></v-text-field>
                                <v-checkbox
                                        label="Schrijf in op de nieuwsbrief"
                                        v-model="form.newsletter"
                                        name="newsletter"
                                />
                                <v-checkbox
                                        v-model="conditions"
                                        label="Algemene Voorwaarden"></v-checkbox>

                                <v-btn
                                        :disabled="!conditions || loading"
                                        color="primary"
                                        type="submit"
                                        :loading="saving"
                                >Registreer
                                </v-btn>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>

                            <v-spacer/>

                            <v-btn small flat>Klik hier om de algemene voorwaarden te lezen</v-btn>
                        </v-card-actions>
                    </v-card>

                </v-flex>
            </v-layout>
        </v-container>

    </v-app>
</template>

<script>
    import {Form} from "../../../Form";

    export default {
        name: "UserRegisterComponent",
        props: ['errors'],
        data() {
            return {
                form: new Form(
                    {
                        email: '',
                        password: '',
                        firstname: "",
                        lastname: "",
                        newsletter: false,
                        phone: "",
                        password_confirmation: "",

                    }
                ),
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                conditions:false
            }

        },
        mounted() {
            this.form.setErrors(this.errors)
        }
    }
</script>

<style scoped>

</style>
