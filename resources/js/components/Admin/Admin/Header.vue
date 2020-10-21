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
                    src="/img/navigation.jpg"
            >

                <v-layout pa-2 column fill-height class="lightbox blue--text">
                    <v-flex shrink>
                        <div class="title pb-3"></div>
                    </v-flex>
                </v-layout>
            </v-img>
            <!--            <v-toolbar style="height:200px;" class="blue-grey darken-3">

                        <v-list>
                              <v-list-tile>

                                  <v-list-tile-title><div style="font-size:30px; ">Artotheek#44</div></v-list-tile-title>


                              </v-list-tile>
                              <v-list-tile>
                                  <v-list-tile-title><div>Beheerder</div></v-list-tile-title>
                              </v-list-tile>
                          </v-list>
            </v-toolbar>-->
            <v-spacer></v-spacer>
            <v-list>
                <v-list-group v-for="menuItem in itemgroup" :key="menuItem.title">
                    <v-list-tile slot="activator" v-if="menuItem.hasOwnProperty('items')">
                        <v-list-tile-title>{{menuItem.title}}</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile append v-for="item in menuItem.items" :key="item.title"
                                 v-on:click="$router.push({name:item.action})">
                        <v-list-tile-title>{{item.title}}</v-list-tile-title>

                    </v-list-tile>
                </v-list-group>

                <v-list-tile v-for="menuItem in noItemgroup" :key="menuItem.title"
                             v-on:click="$router.push({name:menuItem.action})">
                    <v-list-tile-action>{{menuItem.title}}</v-list-tile-action>
                </v-list-tile>
            </v-list>
            <v-divider></v-divider>
            <app-auth-button color="dark"></app-auth-button>
            <v-btn flat v-on:click="reload"><v-icon>refresh</v-icon></v-btn>

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
            menuItems(){
                let item =  [

                    {title: 'Ledenlijst', action: 'userlist'},
                    {title: 'Verhuurfiches', action: 'artworklist'},
                    {title: 'Reserveringen', action: 'reservationlist'},
                    {title: 'Ontleningen', action: 'rentlist'},
                    {title: 'Betalingen', action: 'payments'},
                    {title: 'Cadeaubonnen', action: 'vouchers'},
                    {title: 'Artiesten', action: 'artistlist'},
                    {title:'Lidkaarten', action: 'subscriptionlist'},
                    {title:'Disciplines', action: 'disciplinelist'}
                ]

                if (this.issuperadmin){
                    item.push({title:'Vrijwilligers',action:'volunteerlist'})
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
            reload(){
                this.$store.dispatch('entities/deleteAll')
                User.dispatch('loggedInUser')

                User.dispatch('fetch')
                    .then(response => {

                    });


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
