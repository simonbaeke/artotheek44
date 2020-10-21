<template>
    <div>
        <v-footer v-if="showcookiefooter"
                  class="container"

                  fixed
                  text
                  color="black"
                  v-model="show"
        >
            <v-row>
                <v-col xs="12 md=8">
                    <h1 class="text-h1 white--text">Cookies</h1>
                    <div class="white--text">
                        Door deze site te gebruiken, gaat u akkoord met ons gebruik van cookies.
                        Wij gebruiken cookies om u een verbeterde ervaring te bieden en om de goede werking van onze
                        website te optimaliseren.
                    </div>
                    <div>
                        <v-dialog
                                v-model="showmore"
                                persistent
                                max-width="600px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                        class="mt-8" dark small
                                        v-bind="attrs"
                                        v-on="on"
                                >
                                    Meer weten
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    Cookies
                                </v-card-title>
                                <v-card-text>
                                    Eigenlijk worden er geen cookies gebruikt dit is voor de show
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn v-on:click="showmore=false"
                                    >Sluiten
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                    </div>
                </v-col>
                <v-col xs="12" md="4" class="d-flex justify-center align-center">
                    <v-btn
                            text
                            dark
                            outlined
                            v-on:click="enableCookies"

                    >
                        ik ga akkoord
                    </v-btn>
                </v-col>
            </v-row>

        </v-footer>

        <cookie-information :dialog="information" v-on:close="information=false"></cookie-information>
    </div>
</template>

<script>
    import cookieInformation from './CookieInformation'
    import User from '../store/orm/User'

    export default {
        name: "CookieSnackbar",
        props: ['message', 'index',],


        data() {
            return {
                showcookiefooter: false,
                showmore: false,
                information: false,
                show: true,
                timeout: 0,
                text: "Deze website maakt gebruik van cookies. Door gebruik te maken van deze website geeft u toestemming voor het plaatsen van cookies."
            }
        },
        computed: {
            user() {
                return User.getters('loggedInUser')
            }
        },
        methods: {
            enableCookies() {
                var d = new Date();
                d.setTime(d.getTime() + (1000 * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = 'artotheek' + "=" + 'cookies' + ";" + expires + ";path=/";
                this.showcookiefooter = false
            },
            getCookie() {
                var name = 'artotheek' + "=";
                var ca = document.cookie.split(';');
                for(var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return true
                        return c.substring(name.length, c.length);
                    }
                }
                return false;
            },
            setGdpr(value) {

                if (this.user.id > -1) {
                    User.dispatch('setPreference', {key: 'gdpr', value: value})
                } else {

                    //check if cookie exists

                    var d = new Date();
                    d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
                    var expires = "expires=" + d.toUTCString();
                    document.cookie = 'tracking' + "=" + value + ";" + expires + ";path=/";
                }

                this.$emit('close', this.index)
            }
        }, mounted() {


            if(!this.getCookie()){
                this.showcookiefooter = true
            }

        },
        components: {
            cookieInformation
        }
    }
</script>

<style scoped>
    .container {
        opacity: .9;
        padding: 1rem 2rem;
        height: 30%;
    }

    .v-dialog {
        position: absolute;
        bottom: 0px;
    }

    @media only screen and (min-width: 600px) {
        .container {
            width: 100%;
            max-width: 100% !important;

        }
    }

</style>
