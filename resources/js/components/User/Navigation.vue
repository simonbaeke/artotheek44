<template>
    <div>
        <v-app-bar
                fixed
                scroll-off-screen
                color="#044E7F"
                dark
        >
            <router-link tag="v-toolbar-title" flat :to="{name:'landing'}" v-on:click="">Artotheek#44</router-link>
            <v-spacer></v-spacer>

            <slot name="search"></slot>

<filter-menu/>


            <v-spacer></v-spacer>
            <v-toolbar-side-icon @click="sideNav=!sideNav" class="hidden-sm-and-up"></v-toolbar-side-icon>

            <v-toolbar-items class="hidden-xs-only">
                <v-btn text v-for="item in menuItems" :key="item.title"
                       v-on:click="enterRoute(item.link)"
                >{{item.title}}
                </v-btn>


                <app-auth-button color="white"></app-auth-button>

            </v-toolbar-items>
        </v-app-bar>
        <v-navigation-drawer v-model="sideNav" class="hidden-sm-and-up" absolute clipped>
            <v-toolbar flat class="transparent">
                <v-list>
                    <v-list-item>
                        <v-list-item-title class="title ml-4">
                            Artotheek#44
                        </v-list-item-title>
                    </v-list-item>
                </v-list>

                <v-list class="pa-0 nav__header">
                    <app-auth-button></app-auth-button>
                </v-list>
            </v-toolbar>


            <v-list dense>
                <v-divider></v-divider>
                <v-list-item>
                    <v-list-item-action>
                        <v-icon>search</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-text-field
                                solo
                                flat
                                light
                                clearable
                                label="Zoek"
                                v-model="search"
                        />
                    </v-list-item-content>

                </v-list-item>

                <v-divider></v-divider>
                <v-list-item v-for="item in menuItems" :key="item.title">
                    <v-list-item-action v-on:click="$router.push({name:item.link})">
                        {{item.title}}
                    </v-list-item-action>
                </v-list-item>


            </v-list>


        </v-navigation-drawer>


    </div>
</template>

<script>
    import authButton from '../AuthButton.vue'
    import filterMenu from './Artwork/FilterMenu'
    import {EventBus} from "../../Event";

    export default {
        name: "Navigation",
        data() {


            return {
                extended: false,
                sideNav: false,
                showLoginModal: false,
                menuItems: [
                    {title: 'Catalogus', link: 'catalogus'},
                    {title: 'Artiesten', link: 'userArtistList'}
                ],
                search: ""
            }
        },

        watch: {
            // whenever question changes, this function will run
            search() {
                EventBus.$emit('search', this.search)
            }

        },
        computed: {

            user() {
                let user = this.$store.getters['entities/users/loggedInUser']

                if (user) {
                    return user
                }

                return {firstname: 'gast'}
            },

            loggedIn() {
                return this.$store.getters['entities/users/isLoggedIn']
            },

            isAdmin() {
                return this.$store.getters['entities/users/isAdmin']
            }
        },

        methods: {
            logout() {
                this.$store.dispatch('logout');
            },
            enterRoute(routeName) {
                this.$router.push({name:routeName})
            }
        },
        components: {
            appAuthButton: authButton,
            filterMenu
        },
        created() {
            EventBus.$on('resetSearchstring', () => {
                this.search = ""
            })
        }
    }
</script>


<style>
    .v-toolbar__title {
        cursor: pointer;
    }

    .v-input__slot {
        margin-top: 0.35rem;

    }

    .v-input__control {
        min-height: 2rem !important;

    }

    @media (max-width: 56.25em) {
        .v-list--dense {
            padding-top: 0;
        }

        #app > div.application--wrap > div:nth-child(1) > aside > nav > div {
            height: 10rem !important;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            padding: 0;
        }

        #app > div.application--wrap > div:nth-child(1) > aside > nav > div > div {
            width: 100%;
            flex-grow: 0;
        }
    }

    @media (min-width: 56.25em) {
        .v-input__slot {
            margin-bottom: 0;
            border-radius: 100px !important;
            padding: 0 1.5rem !important;
        }

        .v-input__control {
            min-height: 2rem !important;

        }
    }


</style>
