<template>
    <app-content>
        <template slot="toolbar">
            <v-flex xs6  v-if="subscription!=null">
                Lidkaart {{subscription.number}} van {{subscription.user.firstname}}

            </v-flex>
            <v-spacer/>

        </template>
        <template slot="text">
            <subscription-detail-content
                    :show-title="false"
                    :subscription-id="$route.params.id"
                    v-on:close="back"
            >
                Terug
            </subscription-detail-content>

        </template>
    </app-content>
</template>

<script>
    import appContent from '../basis/content'
    import subscriptionDetailContent from './SubscriptionDetailContent'

    import Subscription from '../../../store/orm/Subscription'

    export default {
        name: "SubscriptionDetail",
        methods: {
            back() {
              this.$router.push({name:'subscriptionlist'})
            }
        },
        computed: {
            subscription() {
                return Subscription.query().where('id',this.$route.params.id).withAll().first()

            }
        },
        components: {
            appContent,
            subscriptionDetailContent
        }
    }
</script>

<style scoped>

</style>
