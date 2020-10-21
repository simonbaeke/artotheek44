<template>
    <div>

        <div v-if="!loading">
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
                        <v-flex md6 class="hidden-sm-and-down"></v-flex>


                        <v-flex xs12 v-for="phonenumber,index in form.phone" :key="index">
                            <v-layout row wrap
                                      v-if="form.deletePhoneNumbers.findIndex(item => {return item == phonenumber.id})< 0">
                                <v-flex xs4 md2 class="pr-2">
                                    <v-select
                                            :items="phoneTypes"
                                            item-text="name"
                                            item-value="id"
                                            label="Telefoon of GSM"
                                            v-model="form.phone[index].type"
                                    ></v-select>

                                </v-flex>
                                <v-flex xs6 md4>
                                    <v-text-field
                                            type="tel"
                                            v-on:keydown="form.clearError('phone')"
                                            :error-messages="form.error('phone','Telefoonnummer')"
                                            :error="form.hasError('phone')"
                                            v-model="form.phone[index].number"
                                            label="Telefoonnummer">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs2 md2>
                                    <v-btn text v-on:click="form.deletePhoneNumbers.push(phonenumber.id)">
                                        <v-icon>delete_outline</v-icon>
                                    </v-btn>
                                </v-flex>
                                <v-flex md4 class="hidden-sm-and-down"></v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 v-for="phonenumber,index in form.newPhoneNumbers" :key="index">
                            <v-layout row wrap>
                                <v-flex xs4 md2 class="pr-2">
                                    <v-select
                                            :items="phoneTypes"
                                            item-text="name"
                                            item-value="id"
                                            label="Telefoon of GSM"
                                            v-model="form.newPhoneNumbers[index].type"
                                    ></v-select>

                                </v-flex>
                                <v-flex xs6 md4>
                                    <v-text-field
                                            type="tel"
                                            v-on:keydown="form.clearError('phone')"
                                            :error-messages="form.error('phone','Telefoonnummer')"
                                            :error="form.hasError('phone')"
                                            v-model="form.newPhoneNumbers[index].number"
                                            label="Telefoonnummer">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs2 md2>
                                    <v-btn text v-on:click="form.newPhoneNumbers.splice(index,1 )">
                                        <v-icon>delete_outline</v-icon>
                                    </v-btn>
                                </v-flex>
                                <v-flex md4 class="hidden-sm-and-down"></v-flex>
                            </v-layout>
                        </v-flex>


                        <v-flex xs12 md6>
                            <v-btn text v-on:click="addPhoneNumber">Extra telefoonnummer toevoegen</v-btn>
                        </v-flex>

                        <v-flex xs12 md11>
                            <v-text-field
                                    v-on:keydown="form.clearError('street')"
                                    :error-messages="form.error('street','Straat')"
                                    :error="form.hasError('street')"
                                    v-model="form.street"
                                    label="Straat">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md11>
                            <v-text-field
                                    v-on:keydown="form.clearError('number')"
                                    :error-messages="form.error('number','Huisnummer')"
                                    :error="form.hasError('number')"
                                    v-model="form.number"
                                    label="Huisnummer">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md11>
                            <v-text-field
                                    v-on:keydown="form.clearError('zip')"
                                    :error-messages="form.error('zip','Postcode')"
                                    :error="form.hasError('zip')"
                                    v-model="form.zip"
                                    label="PostCode">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md11>
                            <v-text-field
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
                <v-btn :loading="saving" text v-on:click="save">Opslaan</v-btn>
                <v-btn text v-on:click="$emit('cancel')">Annuleren</v-btn>
            </v-card-actions>
        </div>
        <div v-if="loading">
            <div class="text-xs-center">
                <v-progress-circular
                        indeterminate
                        color="primary"
                />
            </div>
        </div>


    </div>
</template>

<script>
    import User from '../../../store/orm/User'
    import {Form} from '../../../Form.js'
    import {EventBus} from "../../../Event";
    import appContent from '../basis/content'

    export default {
        name: "UserEdit",
        props: [''],
        data() {
            return {
                form: new Form({
                    firstname: "",
                    lastname: "",
                    email: "",
                    id: "",
                    phone: [{number: "", type: 1}],
                    street: "",
                    number: "",
                    zip: "",
                    city: "",
                    newPhoneNumbers: [],
                    deletePhoneNumbers: [],
                }),
                saving: false,
                loading: false,

                phoneTypes: [{id: 1, name: 'Telefoon'}, {id: 2, name: 'Gsm'}]
            }
        },
        computed: {
            user() {
                return User.query().with('address').find(this.$route.params.id)
            }
        },
        methods: {
            save() {
                this.saving = true
                User.dispatch('updateUser', this.form)
                    .then(response => {

                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Gegevens van ' + response.data.data.firstname+' zijn gewijzigd'
                        })

                        this.$emit('cancel')
                        this.saving = false

                    })
                    .catch(error => {
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Fout bij wijzigen ' + error,
                            type:'error'
                        })
                        this.form.setErrors(error)
                        this.saving = false
                    });
            },
            reset() {
                this.form.firstname = this.user.firstname
                this.form.lastname = this.user.lastname
                this.form.email = this.user.email
                this.form.id = this.user.id
                this.form.phone = this.user.phoneNumbers
                if (this.user.address != null){
                    this.form.street = this.user.address.street
                    this.form.city = this.user.address.city
                    this.form.zip = this.user.address.zip
                    this.form.number = this.user.address.number
                }

            },

            addPhoneNumber() {
                this.form.newPhoneNumbers.push({number: "", type: 1})
            }

        },
        mounted() {
            this.reset()
            // this.loading = true
            User.dispatch('fetchUser', this.$route.params.id).then(response => {
                this.reset()
                this.loading = false

            })

        },
        components: {
            appContent
        }

    }
</script>

<style scoped>

</style>
