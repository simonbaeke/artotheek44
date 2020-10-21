<template>
    <div>
        <v-app-bar
                app
                absolute
                scroll-treshold="1"
                scroll-off-screen
                color="rgba(0, 0, 0,0)"
                flat
        >
            <v-toolbar-title style="font-size:1.25rem;" v-on:click="mivalti" text class="white--text">
              Artotheek#44
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items>
                <v-btn v-on:click="instagram" text color="white"><i class="fab fa-instagram"
                                                             style="font-size:32px;"></i></v-btn>
                <v-btn v-on:click="facebook" text color="white"><i class="fab fa-facebook" style="font-size:32px;"></i>
                </v-btn>
                <v-btn color="white" text v-on:click="enterCatalogus">Catalogus</v-btn>
                <app-auth-button  color="white"></app-auth-button>
            </v-toolbar-items>
        </v-app-bar>
        <v-app-bar
                app
                inverted-scroll
                scroll-treshold="1"
                scroll-off-screen
                color="white"
        >
            <v-toolbar-title>
                Artotheek#44
            </v-toolbar-title>
            <v-spacer></v-spacer>

            <v-toolbar-items>


                <v-btn v-on:click="instagram" text color="primary"><i class="fab fa-instagram"
                                                                     style="font-size:32px;"></i></v-btn>
                <v-btn v-on:click="facebook" text color="primary"><i class="fab fa-facebook"
                                                                     style="font-size:32px;"></i></v-btn>




                <v-btn color="#487eb0" text v-on:click="$router.push({name:'artwork'})">Catalogus</v-btn>
                <v-btn color="#487eb0" text v-on:click="$router.push({name:'artists'})">Kunstenaars</v-btn>
                <app-auth-button color="#487eb0"></app-auth-button>
            </v-toolbar-items>
        </v-app-bar>
    </div>
</template>

<script>
    import authButton from '../AuthButton.vue'
    import loginForm from '../LoginForm.vue'
    import {EventBus} from "../../Event";

    export default {
        name: "LandingNavigation",
        data() {
            return {
                showLoginModal: false
            }
        },
        methods: {
            facebook() {
                window.location.href = "https://www.facebook.com/Artotheek44/"
            },
            mivalti() {
                window.location.href = "https://www.artotheek44.be"
            },
            showLoginDialog() {
                EventBus.$emit('showLoginDialog')
            },
            instagram(){
                window.location.href = "https://www.instagram.com/"

            },
            enterCatalogus(){
                window.location.href='/catalogus'
            }
        },

        computed: {

            user() {
                return this.$store.getters['entities/users/loggedInUser']
            },
            error() {
                return this.$store.getters.error
            },
            loading() {
                return this.$store.getters.loading
            },

            loggedIn() {
                return this.$store.getters.loggedInStatus
            }
        },
        components: {
            appAuthButton: authButton,
            loginForm: loginForm
        }
    }
</script>

<style scoped>


    .v-dialog__container {
        display: flex !important;
        align-items: center;
        height: inherit;
    }

    .v-dialog__activator {
        cursor: pointer;
        height: inherit;
    }

    .v-toolbar__title{
        font-size: 1.25rem;
        color:#487eb0;
    }

