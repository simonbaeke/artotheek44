<template>
    <v-app>
        <v-tabs fixed-tabs>
            <v-tab v-on:click="selectedComponent='userSubscriptions'">Lidkaarten</v-tab>
            <v-tab class="v-tabs__item--active" @click="selectedComponent='userInfo'">UserDetails</v-tab>
        </v-tabs>

        <v-progress-linear v-if="api.loading" :indeterminate="true"></v-progress-linear>
        <v-container v-if="!api.loading">

            <keep-alive>
                <component
                        :is="selectedComponent"
                        :userData="user"/>
            </keep-alive>

            <div class="loading-error" v-if="api.error">
                <p>{{api.errorMessage}}</p>
            </div>
        </v-container>

    </v-app>
</template>

<script>
    import loadingIndicator from '../../LoadingIndicator';
    import userInfo from './UserInfo.vue'
    import userSubscriptions from './UserSubscriptions.vue'
    import Subscription from '../../../store/orm/Subscription'
    import User from '../../../store/orm/User'

    export default {
        name: "UserDetail",

        data() {
            return {
                selectedComponent: 'userSubscriptions'
            }
        },
        methods: {
            isSelectedComponent(component) {
                if (this.selectedComponent == component) {
                    return true
                }
                return false;
            }
        },
        computed: {
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            }
        },
        mounted() {
            Subscription.dispatch('fetch', 9)
        },
        components: {
            loadingIndicator,
            userInfo,
            userSubscriptions
        }
    }
</script>

<style scoped>
    .mdl-tabs__tab.is-active:after {
        height: 2px;
        width: 100%;
        display: block;
        content: " ";
        bottom: 0;
        left: 0;
        position: absolute;
        background: rgb(105, 197, 243) !important;
        -webkit-animation: border-expand .2s cubic-bezier(.4, 0, .4, 1) .01s alternate forwards;
        animation: border-expand .2s cubic-bezier(.4, 0, .4, 1) .01s alternate forwards;
        transition: all 1s cubic-bezier(.4, 0, 1, 1);
    }

    is-active:after {
        height: 2px;
        width: 100%;
        display: block;
        content: " ";
        bottom: 0;
        left: 0;
        position: absolute;
        background: rgb(0, 188, 212);
        -webkit-animation: border-expand .2s cubic-bezier(.4, 0, .4, 1) .01s alternate forwards;
        animation: border-expand .2s cubic-bezier(.4, 0, .4, 1) .01s alternate forwards;
        transition: all 1s cubic-bezier(.4, 0, 1, 1);
    }
</style>
