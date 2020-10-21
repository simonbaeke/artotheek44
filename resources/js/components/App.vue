<template>
    <v-app light>
        <slot></slot>
        <construction-dialog :construction="construction" v-on:close="construction=false"/>

        <router-view name="nav">
            <template slot="search">
                <router-view name="search"></router-view>
            </template>
            <template slot="auth">
            </template>
        </router-view>

        <router-view name="content" :errors="errors" :old="old"></router-view>



        <router-view name="sidebar"></router-view>
        <!--        <verified-snackbar :snack="verifiedsnack" v-on:close="verifiedsnack=false"></verified-snackbar>
                <cookie-snackbar
                        :snack="snack"
                        v-on:close="snack=false"
                        v-on:information="information=true"
                />-->
        <message-list/>

        <template slot="message"></template>
        <router-view name="footer"></router-view>


    </v-app>
</template>

<script>

    import authDialog from './AuthDialog'
    import User from '../store/orm/User'
    import cookieSnackbar from './CookieSnackbar'
    import cookieInformation from './CookieInformation'
    import verifiedSnackbar from './VerifiedSnackbar'
    import messageList from './MessageList'
    import constructionDialog from './ContstructionDialog'
    import {EventBus} from "../Event";


    export default {
        name: "App",
        props: {
            user: {
                default: null
            },
            errors: {
                default: ""
            },
            path: {
                default: '/'
            },
            old: {
                default: ""
            }
        },
        data() {
            return {
                snack: true,
                verifiedsnack: false,
                information: false,
                construction: true
            }
        },
        methods: {},
        components: {
            cookieSnackbar,
            cookieInformation,
            verifiedSnackbar,
            messageList,
            authDialog,
            constructionDialog
        },
        watch: {
            loggedInUser() {
                if (this.loggedInUser.id == -1) {
                    User.dispatch('loggedInUser', this.user)

                }

            }
        },
        computed: {
            loggedInUser() {
                return this.$store.getters['entities/users/loggedInUser']
            }
        },
        created() {
            if (this.user != null) {
                User.dispatch('loggedInUser', this.user)
               // axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.user.token;
            }

            EventBus.$on('showConstructionDialog', () => {
                this.construction = true
            })

            EventBus.$on('clearError', () => {
                this.errors = []
            })

        },
        mounted() {


            if (this.user) {
                if (!this.user.verified) {
                    EventBus.$emit('message', {
                        component: 'verifiedSnackbar',
                        message: ""
                    })
                }
            }

        }
    }
</script>

<style scoped>
    .v-parallax__content {
        background-image: linear-gradient(rgba(72, 126, 176, 0.8), rgba(0, 0, 0, 0.7)) !important;

    }

    .v-toolbar:first-child {
        box-shadow: none !important;
    }


</style>
