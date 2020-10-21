<template>
    <v-app>

        <v-toolbar
                color="primary"
                dark>
            <v-toolbar-title>Artotheek#44</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field
                    append-icon="search"
                    color="white"
            ></v-text-field>
            <v-spacer></v-spacer>
            <v-toolbar-side-icon @click="sideNav=!sideNav" class="hidden-sm-and-up"></v-toolbar-side-icon>

            <v-toolbar-items class="hidden-xs-only">
                <v-btn flat v-for="item in menuItems" :key="item.title">{{item.title}}</v-btn>


                <v-menu
                        transition="slide-y-transition"
                        bottom
                >
                    <v-btn
                            flat
                            slot="activator"
                            dark
                    >
                        {{profielMenuKnop}}
                    </v-btn>
                    <v-list>
                        <v-list-tile
                                v-for="(item, i) in items"
                                :key="i"
                                @click=""
                        >
                            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
            </v-toolbar-items>
        </v-toolbar>
        <v-navigation-drawer v-model="sideNav" class="hidden-sm-and-up">
            <v-list>
                <v-list-tile>
                    <v-list-tile-content>
                        Catalogus
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <main>

        </main>
    </v-app>
</template>

<script>
    export default {
        name: "App", computed: {
            logout() {
                return 'logout'
            }
        },
        data() {

            return {
                logout: 'logout',
                sideNav: false,
                menuItems: [
                    {title: 'Catalogus'},
                    {title: 'Artiesten'}
                ],
                items: [
                    {title: 'Sign In'},
                    {title: 'Sign Up'},
                    {title: 'Register'},
                    {title: 'Profiel'}
                ]
            }
        },
        computed: {
            profielMenuKnop() {
                return 'Hallo gast'
            }
        }


    }

</script>

<style scoped>
    input {
        border-bottom: 1px solid white;
    }
</style>
