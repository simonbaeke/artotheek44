<template>
    <v-app v-if="user">

        <v-layout v-if="loading" class="text-center">
            <v-flex xs12>

                <div class="center">
                    <v-progress-circular
                            class="middle"
                            :size="70"
                            :width="7"
                            color="#044E7F"
                            indeterminate
                    ></v-progress-circular>
                </div>
            </v-flex>
        </v-layout>


        <v-card v-if="!loading" flat class="pa-4 mt-5">
            <v-form>
                <v-container>
                    <v-layout row wrap>
                        <v-flex xs12 md4>
                            <v-text-field
                                    v-model="user.firstname"
                                    label="Voornaam"
                                    readonly
                            >

                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md4>
                            <v-text-field
                                    v-model="user.lastname"
                                    label="Familienaam"
                                    readonly
                            >

                            </v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 md4>
                            <v-text-field
                                    v-model="user.email"
                                    label="Email"
                                    readonly
                            >

                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 md4>
                            <v-text-field
                                    v-model="user.phone"
                                    label="Telefoonnummer"
                                    readonly
                            >

                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-form>

            <v-divider></v-divider>

            <v-layout column class="mt-4">
                Voorkeuren
                <v-checkbox :disabled="edit"
                            v-model="user.preferences.newsletter"
                            label="Ontvang de nieuwsbrief"
                            v-on:click.stop="updatePreference('newsletter')"/>
                <v-checkbox
                        :disabled="edit"
                        v-model="user.preferences.notifications"
                        label="Ontvang email meldingen"
                        v-on:click.stop="updatePreference('notifications')"
                />
            </v-layout>

            <span v-if="!user.verified" class="error--text"><v-icon color="error" class="mr-2">warning</v-icon>Uw email adres is nog niet bevestigd</span>
            <v-btn

                    v-if="!user.verified"
                    color="primary"
                    outlined
                    @click="resend">Zend een nieuwe bevestingsmail
            </v-btn>


            <v-divider></v-divider>
            <v-container>
                <v-layout>
                    <v-flex xs12 md4>
                        <v-btn outlined v-on:click="dialog=true">Wijzig wachtwoord</v-btn>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Wijzig wachtwoord</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap column>
                            <v-flex xs12 sm6 md4>
                                <password-field
                                        :closed="dialog"
                                        :error="oldpwerror"
                                        :errormessage="passwords.error('old_password')"
                                        label="Oud wachtwoord"
                                        v-on:changePassword="passwords.old_password = $event"
                                        v-on:clearError="passwords.clearError('old_password')"
                                />
                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <password-field
                                        :closed="dialog"
                                        :error="passwords.hasError('password')"
                                        :errormessage="passwords.error('password')"
                                        label="Nieuw wachtwoord"
                                        v-on:changePassword="passwords.password = $event"
                                />

                            </v-flex>
                            <v-flex xs12 sm6 md4>
                                <password-field
                                        :closed="dialog"

                                        v-on:changePassword="passwords.password_confirmation = $event"
                                        label="Bevestig nieuw wachtwoord"/>

                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn text @click="dialog = false">Annuleren</v-btn>
                    <v-btn text @click="changePassword">Wijzigen</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>

</template>

<script>
    import passwordField from '../../PasswordField'
    import User from '../../../store/orm/User'
    import {EventBus} from "../../../Event";
    import {Form} from "../../../Form";

    export default {
        name: "UserInfo",
        props: ['user'],
        data() {
            return {
                loading:false,
                edit: false,
                dialog: false,
                passwords: new Form({
                    old_password: "",
                    password: "",
                    password_confirmation: ""
                })
            }
        },
        methods: {

            resend() {
                axios.get('api/email/resend').then((response) => {
                    console.log(response)

                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Er is een nieuwe bevestigingsmail verzonden, deze is 1 uur geldig',
                        type: 'info'
                    })
                })
            },
            updatePreference(key) {
                if (!this.edit) {
                    this.edit = true
                    User.dispatch('setPreference', {
                        key: key,
                        value: !this.user.preferences[key]
                    }).then(() => {
                        this.edit = false
                    }).catch(() => {
                        this.edit = false
                    })
                }

            },
            changePassword() {
                //this.dialog=false
                axios.post('/api/password/change', this.passwords.data()).then((response) => {
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: response.data.message,
                        type: 'success'
                    })

                }).catch(error => {
                    if (error.request.status == 422) {
                        this.passwords.setErrors(JSON.parse(error.request.response).errors)

                    } else {
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Fout bij wijzigen wachtwoord',
                            type: 'error'
                        })
                    }

                })

            }
        },
        computed:{
            oldpwerror(){
                return this.passwords.hasError('old_password')
            }
        },
        components: {
            passwordField
        },
        mounted(){
            this.loading=true
            User.dispatch('fetchUser',this.user.id).then(()=>{this.loading=false})
                .catch(()=>{this.loading = false})
        }
    }
</script>

<style scoped>
    .mdl-card {
        width: 100%;
    }

    .mdl-textfield__label {
        position: inherit;
    }

    .container {
        margin-top: 4rem;
    }

    .center{
        height:100vh;
        position: relative;
    }

    .middle{
        position: absolute;
        top:50%;
        left:50%;
        transform:translateX(-50%);
        transform:translateY(-50%);
    }
</style>
