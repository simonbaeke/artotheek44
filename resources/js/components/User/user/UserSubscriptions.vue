<template>
    <v-app>
        <v-container fluid v-if="!loading">
            <v-alert outlined :value="subscriptions.length == 0" color="red" icon="new_releases">Geen abonnement
                gevonden
            </v-alert>


            <user-subscription v-for="subscription in subscriptions" :key="subscription.id"
                               :subscription="subscription" :editing="editSubscriptions"></user-subscription>

        </v-container>

        <v-layout v-if="loading" class="text-center">
            <v-flex xs12>

                <div class="center">
                    <v-progress-circular
                            class="middle"
                            :size="70"
                            :width="7"
                            color="#044E7F"
                            indeterminate
                    ></v-progress-circular>
                </div>
            </v-flex>
        </v-layout>
    </v-app>
</template>

<script>
    import userSubscription from './UserSubscription.vue';
    import Subscription from '../../../store/orm/Subscription'

    export default {
        name: "UserSubscriptions",
        props: ['user'],
        data() {
            return {
                editSubscriptions: false,
                loading: false
            }
        },
        computed: {
            subscriptions() {
                return Subscription.query().where('user_id', this.user.id).with('rents.*').with('reservations.*').all()
            }
        },
        methods: {},
        components: {
            userSubscription
        },

        mounted() {

            this.loading = true
            Subscription.dispatch('fetch').then(response => {
                this.loading = false
            }).catch((error) => {
                this.loading = false
            })
        },
    }
</script>

<style scoped>
    .container {
        margin-top: 4rem;
    }

    .center {
        height: 100vh;
        position: relative;
    }

    .middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%);
        transform: translateY(-50%);
    }
</style>
