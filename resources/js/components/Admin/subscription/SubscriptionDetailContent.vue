<template>

        <v-card class="elevation-0" v-if="subscription!=null">
            <v-card-title v-if="showTitle">
                Lidkaart {{subscription.number}} van {{subscription.user.firstname}}
            </v-card-title>



            <v-card-text >
                <v-tabs
                        v-model="selectedComponent"
                        class="elevation-0"
                        dark

                >
                    <v-tabs-slider></v-tabs-slider>

                    <v-tab
                            v-for="tab in tabs"
                            :key="tab.tab"
                    >
                        {{ tab.tab }}
                    </v-tab>

                    <v-tab-item
                            v-for="tab in tabs"
                            :key="tab.component"
                    >
                        <component
                                :is="tab.component"
                                :subscription="subscription"
                                :loading="loading"
                                v-on:cancel="showSubscriptionList"
                                v-on:edit="selectedComponent = 'subscriptionTab'"/>
                    </v-tab-item>
                </v-tabs>
            </v-card-text>
            <v-card-actions>
                <v-btn text @click="$emit('close')">
                    <slot></slot>
                </v-btn>
            </v-card-actions>
        </v-card>

</template>

<script>
    import subscriptionHistory from './SubscriptionHistoryTab'
    import subscriptionTab from './SubscriptionTab'
    import Subscription from '../../../store/orm/Subscription'

    export default {
        name: "SubscriptionDetailContent",
        props: {
            subscriptionId: {
                required: true
            },
            showTitle:{
                default:true
            }
        },
        data() {
            return {
                loading:false,
                selectedComponent: 0
            }
        },
        computed: {
            tabs() {
                return [
                    {tab: 'Lidkaart', component: 'subscriptionTab'},
                    {tab: 'Overzicht ontleningen', component: 'subscriptionHistory'}
                ]
            },
            subscription() {
                return Subscription.query().where('id',this.subscriptionId).withAll().first()

            }
        },
        methods: {
            showSubscriptionList() {

            }
        },
        components: {
            subscriptionHistory,
            subscriptionTab
        },
        mounted() {
           // this.loading = true
            Subscription.dispatch('fetch',{id:this.subscriptionId } )
                .then(response => {
                    this.loading=false
                })
        }
    }
</script>

<style scoped>

</style>
