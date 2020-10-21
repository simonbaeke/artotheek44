<template>
    <v-app>
        <slot name="navigation"></slot>


        <slot name="content"></slot>

        <slot name="footer"></slot>
    </v-app>

</template>

<script>
    import appNavigation from './User/Navigation'
    import User from '../store/orm/User'

    export default {
        name: "SiteComponent",
        props: {
            user: {
                default: null
            }
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

            axios.get('/sanctum/csrf-cookie').then(response => {
                if (this.user != null) {
                   // User.dispatch('loggedInUser', this.user)
                    //axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.user.token;
                }            });


        }

    }
</script>

<style scoped>

</style>
