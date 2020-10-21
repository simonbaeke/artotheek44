<template>
    <v-container  v-if="!loading">
        <v-layout row xs-12>
            <v-flex xs-12 justify-center>
                <v-tabs
                        color="#fafafa"
                        center
                        slider-color="lime"
                        fixed-tabs>
                    <v-tab
                            color="lime"
                            v-bind:class="{'is-active': selectedComponent=='userSubscriptions'}"
                           v-on:click="selectedComponent='userSubscriptions'">
                        <a>Abonnementen</a>
                    </v-tab>
                    <v-tab v-bind:class="{'is-active': selectedComponent=='userInfo'}"
                           v-on:click="selectedComponent = 'userInfo'">
                        <a>Account</a>
                    </v-tab>

                </v-tabs>
            </v-flex>


        </v-layout>


        <keep-alive>
            <component :is="selectedComponent" :user="user"></component>
        </keep-alive>
        <app-alert></app-alert>

    </v-container>

</template>

<script>
    import UserSubscriptions from './UserSubscriptions.vue'
    import userInfo from './UserInfo.vue'
    import appAlert from '../../Alert.vue'

    export default {
        name: "UserProfile",
        data: function () {
            return {
                selectedComponent: "userSubscriptions"
            }
        },
        computed: {
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            },

            loading(){
                return this.$store.getters['entities/users/loading']
            }
        },

        components: {
            userInfo,
            userSubscriptions: UserSubscriptions,
            appAlert
        }


    }
</script>

<style scoped>

    .container {
        margin-top: 4rem;
    }
</style>
