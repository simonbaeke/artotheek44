<template>
    <v-container>
        <v-layout>
            <v-flex xs12 md4 offset-md4>
                <v-card v-if="tokenIsInvalid" text>
                    <v-card-text>
                        <v-alert type="error">
                        <span>
                            De link is niet meer geldig, vraag een nieuwe aan
                        </span>
                        </v-alert>
                        <v-card-actions>
                            <v-btn text v-on:click="sendpasswordmail">Wachtwoord vergeten</v-btn>

                        </v-card-actions>
                    </v-card-text>

                </v-card>
                <v-card v-else>
                    <v-card-title class="card-header">
                        <div class="title">wachtwoord vergeten</div>
                    </v-card-title>

                    <v-card-text>

                        <span>
                            Kies je wachtwoord
                        </span>
                        <form id="reset" name="reset" method="POST" action="/password/reset">
                            <input type="hidden" name="_token" v-model="token">

                            <v-text-field
                                    type="email"
                                    name="email"
                                    label="Email"
                                    v-model="form.email"
                                    :error="form.hasError('email')"
                                    :error-messages="form.error('email')"

                            />

                            <v-text-field
                                    type="password"
                                    name="password"
                                    label="Nieuw wachtwoord"
                                    v-model="form.password"
                                    :error="form.hasError('password')"
                                    :error-messages="form.error('password')"

                            />

                            <v-text-field
                                    type="password"
                                    name="password_confirmation"
                                    label="Bevestig nieuw wachwoord"
                                    v-model="form.password_confirmation"
                                    :error="form.hasError('email')"
                                    :error-messages="form.error('password_confirmation')"

                            />
                            <input name="token" type="text" v-model="form.token">
                        </form>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn form="reset" type="submit" text>
                            Bevestigen
                        </v-btn>
                    </v-card-actions>

                </v-card>

            </v-flex>

        </v-layout>
    </v-container>

</template>

<script>
    import {Form} from "../../Form";

    export default {
        name: "resetPassword",
        props: ['errors', 'old'],
        data() {
            return {
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                form: new Form(
                    {
                        email: "",
                        password: "",
                        password_confirmation: "",
                        token: ""
                    }
                )
            }
        },
        computed: {
            oldinput() {
                return JSON.parse(this.old)
                console.log(this.old)
            },
            tokenIsInvalid() {
                return this.form.hasError('email') && this.form.error('email').indexOf("token") > -1
            }
        },
        methods: {
            sendpasswordmail() {
                this.$router.push({name: 'resetpassword'})
            }
        },
        mounted() {
            this.form.token = this.$route.params.token
            this.form.setErrors(this.errors)
        }
    }
</script>

<style scoped>
    .container {
        margin-top: 4rem;
    }
</style>
