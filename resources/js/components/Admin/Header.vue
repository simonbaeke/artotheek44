<template>
    <div class="hidden-print-only">
        <!--      <v-toolbar
                        light flat>
                    <v-toolbar-title v-on:click="$router.push({name:'landing'})">Artotheek#44</v-toolbar-title>
                    <v-spacer></v-spacer>


                    <v-spacer></v-spacer>
                    <v-toolbar-side-icon @click="sideNav=!sideNav" class="hidden-sm-and-up"></v-toolbar-side-icon>

                    <v-toolbar-items class="hidden-xs-only">
                        <app-auth-button color="dark"></app-auth-button>
                    </v-toolbar-items>
                </v-toolbar>-->
        <v-navigation-drawer class="grey darken-4" dark app fixed clipped v-model="sideNav">
            <v-img


                    gradient="to top right, rgba(225, 112, 85,0.4), rgba(0,0,0,.3)"
                    src="http://www.tinademeyer.be/artotheek/static/img/header.jpg"
            >

                <v-layout pa-2 column fill-height class="lightbox blue--text">
                    <v-flex shrink>
                        <div class="title pb-3"></div>
                    </v-flex>
                </v-layout>
            </v-img>
            <!--            <v-toolbar style="height:200px;" class="blue-grey darken-3">

                        <v-list>
                              <v-list-item>

                                  <v-list-item-title><div style="font-size:30px; ">Artotheek#44</div></v-list-item-title>


                              </v-list-item>
                              <v-list-item>
                                  <v-list-item-title><div>Beheerder</div></v-list-item-title>
                              </v-list-item>
                          </v-list>
            </v-toolbar>-->
            <v-spacer></v-spacer>
            <v-list>
                <v-list-group v-for="menuItem in itemgroup" :key="menuItem.title">
                    <v-list-item slot="activator" v-if="menuItem.hasOwnProperty('items')">
                        <v-list-item-title>{{menuItem.title}}</v-list-item-title>
                    </v-list-item>
                    <v-list-item append v-for="item in menuItem.items" :key="item.title"
                                 v-on:click="$router.push({name:item.action})">
                        <v-list-item-title>{{item.title}}</v-list-item-title>

                    </v-list-item>
                </v-list-group>

                <v-list-item v-for="menuItem in noItemgroup" :key="menuItem.title"
                             v-on:click="$router.push({name:menuItem.action})">
                    <v-list-item-action>{{menuItem.title}}</v-list-item-action>
                </v-list-item>
            </v-list>
            <v-divider></v-divider>
            <app-auth-button color="dark"></app-auth-button>

        </v-navigation-drawer>

        <login-form :showModal="showLoginModal" v-on:close="showLoginModal = false"></login-form>

    </div>
</template>

<script>
    import authButton from '../AuthButton.vue'
    import loginForm from '../LoginForm.vue'
    import User from '../../store/orm/User'

    export default {
        name: "Navigation",
        data() {

            return {

                sideNav: true,
                showLoginModal: false,


                admins: [
                    ['Management', 'people_outline'],
                    ['Settings', 'settings']
                ],
                cruds:
                    [
                        ['Create', 'add'],
                        ['Read', 'insert_drive_file'],
                        ['Update', 'update'],
                        ['Delete', 'delete']
                    ]
            }
        },

        watch: {
            // whenever question changes, this function will run

        },
        computed: {
            itemgroup() {
                return this.menuItems.filter(menuItem => menuItem.hasOwnProperty('items'));
            },

            noItemgroup() {
                return this.menuItems.filter(menuItem => menuItem.hasOwnProperty('items') == false);
            },

            user() {
                let user = this.$store.getters['entities/users/loggedInUser']
                if (user) {
                    return user
                }
                return {firstname: 'gast'}
            },
            level() {

                return this.$store.getters['entities/users/level']

            },
            error() {
                return this.$store.getters.error
            },
            loading() {
                return this.$store.getters.loading
            },

            loggedIn() {
                return this.$store.getters['entities/users/isLoggedIn']
            },

            isAdmin() {
                return this.user.roles.findIndex(role => role.name == 'admin') > -1
            },
            issuperadmin() {
                return this.$store.getters['entities/users/userHasRole']('superadmin')
            },
            menuItems() {
                let item = [

                    {title: 'Ledenlijst', action: 'userlist'},
                    {title: 'Kunstwerken', action: 'artworklist'},
                    {title: 'Reserveringen', action: 'reservationlist'},
                    {title: 'Ontleningen', action: 'rentlist'},
                    {title: 'Betalingen', action: 'payments'},
                    {title: 'Cadeaubonnen', action: 'vouchers'},
                    {title: 'Kunstenaars', action: 'artistlist'},
                    {title: 'Lidkaarten', action: 'subscriptionlist'},
                    {title: 'Disciplines', action: 'disciplinelist'},
                    {title: 'Homepage wijzigen', action: 'edithomepage'}

                ]

                if (this.level > 1) {
                    item.push({title: 'Orders', action: 'orders'})
                    item.push({title: 'Vrijwilligers', action: 'volunteerlist'})
                    item.push({title: 'Mailchimp', action: 'mailchimp'})
                }


                return item
            }


        },

        methods: {
            logout() {
                this.$store.dispatch('entities/users/logout');
                //redirect
            },

            closeAlert() {
                console.log('close alert')
            },
            reload() {
                this.$store.dispatch('entities/deleteAll')

                User.dispatch('loggedInUser')

                /* User.dispatch('fetch')
                     .then(response => {

                     });
 */

            }
        },
        components: {
            appAuthButton: authButton,
            loginForm
        }

    }
</script>

<style scoped>


</style>
