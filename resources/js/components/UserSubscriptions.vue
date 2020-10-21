<template>
    <v-container grid-list-md>
        <v-layout row v-for="(subscription,index) in subscriptions" :key="subscription.id">
            <v-flex xs12 sm6 offset-sm3>
                <user-subscription :subscription="subscription"></user-subscription>
            </v-flex>
        </v-layout>

    </v-container>
</template>
<script>

    import userSubscription from './UserSubscription.vue'
    import Subscription from  '../store/orm/Subscription'

    export default {
        name: "UserSubscriptions",
        props: ['user'],
        computed: {
            subscriptions() {
                return this.$store.getters['entities/subscriptions/getSubscriptions']
            }
        },

        components: {
            userSubscription
        },
        mounted() {
            console.log('mounted')
            Subscription.dispatch('fetchSubscriptionsByUserId', this.user.id)
        }
    }
</script>

<style scoped>
    .flex {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

</style>
