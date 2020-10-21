<template>
    <v-dialog v-model="dialog">
        <subscription-detail-content
                :subscriptionId="subscriptionId"
                v-on:close="$emit('close')"
        >
           Sluit
        </subscription-detail-content>

    </v-dialog>
</template>

<script>
    import subscriptionDetailContent from './SubscriptionDetailContent'

    export default {
        name: "SubscriptionDialog",
        props: {
            dialog: {
                required: true
            },
            subscriptionId: {
                required: true
            }
        },
        components: {

            subscriptionDetailContent
        },

    }
</script>

<style scoped>

</style>
