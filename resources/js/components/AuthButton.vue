<template>

    <v-menu
            transition="slide-y-transition"
            bottom

    >
        <template v-slot:activator="{ on }">
            <v-btn
                    text
                    :color="color"
                    :loading="loading"
                    v-if="user!='undefined' && user.id>-1"
                    v-on="on"
            >
                <v-icon left>person</v-icon>

                {{user.firstname}}

                <v-icon right>keyboard_arrow_down</v-icon>


            </v-btn>

            <v-btn
                    v-if="user.id<0"
                    :color="color"
                    text

                    v-on:click="showDialog('showLoginDialog')"
            >
                Login
            </v-btn>
        </template>

        <v-list>
            <v-list-item v-if="loggedIn" v-on:click="$router.push({name:'profile'})">
                <v-list-item-title>Profiel</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="loggedIn">
                <v-list-item-title>
                    <v-form action="/logout" method="post">
                        <input type="hidden" v-model="token" name="_token">
                        <button type="submit">Log out</button>
                    </v-form>
                </v-list-item-title>
            </v-list-item>

            <v-list-item v-if="!loggedIn" v-on:click="showDialog('showLoginDialog')">
                <v-list-item-title>Log in</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="!loggedIn" v-on:click="showDialog('showRegisterDialog')">
                <v-list-item-title>Registreer</v-list-item-title>
            </v-list-item>
            <v-list-item v-if="isAdmin && !isAdminRoute" v-on:click="$router.push({name:'admin'})">
                <v-list-item-title>{{role}}</v-list-item-title>
            </v-list-item>

            <v-list-item v-if="isAdminRoute" v-on:click="$router.push({name:'catalogus'})">
                <v-list-item-title>Catalogus</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>


</template>

<script>

    import {EventBus} from "../Event";

    export default {
        name: "AuthButton",
        props: ['color'],
        data() {
            return {
                showLoginModal: false,
                showRegisterModal: false,
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            }
        },
        methods: {
            logout() {
                this.$store.dispatch('entities/users/logout');
                EventBus.$emit('clearmessages')

                //delete messages
                //redirect
                this.$router.push({name: 'landing'})

            },

            showDialog(dialog) {
                EventBus.$emit(dialog)
            }
        },
        computed: {
            url() {
                return axios.defaults.baseURL
            },
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            },

            loggedIn() {
                return this.user.id > -1
            },

            isAdmin() {

                if (this.user && !this.user.roles) {
                    return false
                }

                return (this.user.roles.findIndex(role => {
                        return role.name == 'admin'
                    }) > -1)
                    ||
                    (this.user.roles.findIndex(role => {
                        return role.name == 'vrijwilliger'
                    }) > -1)
            },


            isVrijwilliger() {

            },

            loading() {
                return this.$store.getters['entities/users/loading'] && !this.loggedIn
            },
            isAdminRoute() {
                return this.$route.path.indexOf('admin') > -1
            },
            role() {
                if (this.user.roles.findIndex(role => {
                    return role.name == 'superadmin'
                }) > -1) {
                    return ('Superbeheerder')
                }

                //admin
                if (this.user.roles.findIndex(role => {
                    return role.name == 'admin'
                }) > -1) {
                    return ('Beheerder')
                }
                //vrijwilliger

                if (this.user.roles.findIndex(role => {
                    return role.name == 'vrijwilliger'
                }) > -1) {
                    return ('Vrijwilliger')
                }

                if (this.user.roles.findIndex(role => {
                    return role.name == 'ontlener'
                }) > -1) {
                    return ('ontlener')
                }

                return null
            }


        }
    }
</script>

<style scoped>

</style>
