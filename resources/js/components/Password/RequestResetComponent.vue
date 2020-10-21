<template>
    <v-container>
        <v-layout>
            <v-flex xs12 md4 offset-md4>
                <v-card></v-card>
                <v-card>

                    <v-card-title class="card-header">
                        <div class="title">Wachtwoord vergeten</div>
                    </v-card-title>

                    <v-card-text>

                        <span>
                            Vul je e-mailadres of je login in. We zullen je logingegevens verifiëren en je een e-mail sturen om je wachtwoord opnieuw in te stellen.
                        </span>
                        <form id="reset" name="reset" method="POST" action="/password/email">
                            <input type="hidden" name="_token" v-model="token">

                            <v-text-field
                                    type="email"
                                    name="email"
                                    label="Email"
                                    v-model="form.email"
                                    :error="form.hasError('email')"
                                    :error-messages="form.error('email')"

                            />
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
        name: "RequestResetComponent",
        props: ['errors', 'old'],
        data() {
            return {
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                form: new Form({email: ""})
            }
        },
        computed: {
            oldinput() {
                return JSON.parse(this.old)
            }
        },
        mounted() {

            this.form.email = (JSON.parse(this.old)).email

            this.form.setErrors(this.errors)

        }
    }
</script>

<style scoped>
    .container {
        margin-top: 4rem;
    }
</style>
