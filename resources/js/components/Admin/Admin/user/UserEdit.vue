<template>
    <div>

        <v-form v-on:resetform="reset">
            <v-container>
                <v-layout row wrap>
                    <v-flex xs12 md6>
                        <v-text-field
                                v-model="form.firstname"
                                label="voornaam"
                                :error="form.hasError('firstname')"
                                :error-messages="form.error('firstname')"
                                v-on:focus="form.clearError('firstname')"
                        />
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                v-model="form.lastname"
                                label="familienaam"
                                :error="form.hasError('lastname')"
                                :error-messages="form.error('lastname')"
                                v-on:focus="form.clearError('lastname')"
                        />
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                v-model="form.email"
                                label="email"
                                :error="form.hasError('email')"
                                :error-messages="form.error('email')"
                                v-on:focus="form.clearError('email')"
                        />
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                v-model="form.phone"
                                label="telefoonnummer"
                                :error="form.hasError('phone')"
                                :error-messages="form.error('phone')"
                                v-on:focus="form.clearError('phone')"

                        />
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field
                                :readonly="true"
                                v-model="user.memberid"
                                label="Lidnummer">
                        </v-text-field>
                    </v-flex>

                    <v-flex xs12 md11>
                        <v-text-field
                                box
                                v-on:keydown="form.clearError('street')"
                                :error-messages="form.error('street','Straat')"
                                :error="form.hasError('street')"
                                v-model="form.street"
                                label="Straat">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md11>
                        <v-text-field
                                box
                                v-on:keydown="form.clearError('number')"
                                :error-messages="form.error('number','Huisnummer')"
                                :error="form.hasError('number')"
                                v-model="form.number"
                                label="Huisnummer">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md11>
                        <v-text-field
                                box
                                v-on:keydown="form.clearError('zip')"
                                :error-messages="form.error('zip','Postcode')"
                                :error="form.hasError('zip')"
                                v-model="form.zip"
                                label="PostCode">
                        </v-text-field>
                    </v-flex>
                    <v-flex xs12 md11>
                        <v-text-field
                                box
                                v-on:keydown="form.clearError('city')"
                                :error-messages="form.error('city','Stad')"
                                :error="form.hasError('city')"
                                v-model="form.city"
                                label="Stad">
                        </v-text-field>
                    </v-flex>

                </v-layout>
            </v-container>
        </v-form>
        <v-divider></v-divider>
        <v-card-actions>
            <v-btn :loading="saving" flat v-on:click="save">Opslaan</v-btn>
            <v-btn flat v-on:click="$emit('cancel')">Annuleren</v-btn>
        </v-card-actions>


    </div>
</template>

<script>
    import User from '../../../store/orm/User'
    import {Form} from '../../../Form.js'
    import {EventBus} from "@/Event";
    import appContent from '../basis/content'

    export default {
        name: "UserEdit",
        props: ['user', 'loading', 'address'],
        data() {
            return {
                form: new Form({
                    firstname: "",
                    lastname: "",
                    email: "",
                    id: "",
                    phone: "",
                    street: "",
                    number: "",
                    zip: "",
                    city: ""
                }),
                saving: false
            }
        },
        computed: {
            user() {
                return User.find(this.$route.params.id)
            }
        },
        methods: {
            save() {
                this.saving = true
                User.dispatch('updateUser', this.form)
                    .then(response => {
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Gegevens van lid zijn gewijzigd'
                        })

                        this.$emit('cancel')
                        this.saving = false

                    })
                    .catch(error => {
                        this.form.setErrors(error)
                        this.saving = false
                    });
            },
            reset() {
                this.form.firstname = this.user.firstname
                this.form.lastname = this.user.lastname
                this.form.email = this.user.email
                this.form.id = this.user.id
                this.form.phone = this.user.phone
                this.form.street = this.address.street
                this.form.city = this.address.city
                this.form.zip = this.address.zip
                this.form.number = this.address.number
            }

        },
        mounted() {
            this.reset()
        },
        components: {
            appContent
        }

    }
</script>

<style scoped>

</style>
