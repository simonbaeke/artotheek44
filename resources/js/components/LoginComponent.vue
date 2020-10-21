<template>
    <v-container>
        <v-layout>
            <v-flex xs12 md6 offset-md3>
                <v-form name="form" method="post" action="/login">

                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>Login</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn
                                    white
                                    icon
                                    small
                                    v-on:click.prevent="$emit('close')"
                            >
                                <v-icon small>close</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <input type="hidden" v-model="form._token" name="_token">
                            <v-text-field prepend-icon="person"
                                          name="email"
                                          v-model="form.email"
                                          label="Email"
                                          type="email"
                                          :error="form.hasError('email')"
                                          :error-messages="form.error('email')"
                                          v-on:click="form.clearError('email')"

                                          required/>
                            <v-text-field prepend-icon="lock"
                                          append-icon="visibility"
                                          v-model="form.password"
                                          name="password"
                                          label="Password"
                                          :type="passwordType"
                                          :error="form.hasError('password')"
                                          v-on:click:append="setPasswordVisible"
                                          v-on:focus="form.clearError('password')"

                                          required></v-text-field>
                            <v-checkbox
                                    v-model="form.remember"
                                    label="Blijf ingelogd op dit toestel"
                            ></v-checkbox>
                            <v-btn flat class="grey--text" v-on:click="register">Maak een account aan</v-btn>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                    color="primary"
                                    type="submit"
                            >Login
                            </v-btn>
                            <v-btn color="primary" flat v-on:click="sendpasswordmail">Wachtwoord vergeten</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>

            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {Form} from'../Form.js'
    export default {
        name: "LoginComponent",
        props:['errors']
        ,
        data() {
            return {
                form: new Form({
                    email: '',
                    password: '',
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    remember: false,
                }),
                passwordVisible: false
            }
        },

        computed: {
            passwordType() {
                if (this.passwordVisible) {
                    return 'text'
                }
                return 'password'
            },

        },


        methods: {

            sendpasswordmail() {
                this.$router.push({name:'resetpassword'})
            },
            setPasswordVisible() {

                if (!this.passwordVisible) {
                    this.passwordVisible = true;
                    setTimeout(() => {
                        this.passwordVisible = false;
                    }, 1000)
                    return
                }

                this.passwordVisible = false;


            },
            register() {
                window.location.href = '/register'
            }
        },
        mounted(){
            this.form.setErrors(this.errors)
        }
    }
</script>

<style scoped>
    .container{
        margin-top:5rem;
    }

</style>
