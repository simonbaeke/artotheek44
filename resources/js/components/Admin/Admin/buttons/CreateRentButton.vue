<template>
    <v-tooltip bottom v-if="subscription.available &&!subscription.expired">
        <v-btn icon slot="activator">
            <v-icon small @click="createRent">
                add
            </v-icon>
        </v-btn>
        <span>Nieuwe ontlening</span>
    </v-tooltip>
</template>

<script>
    import {EventBus} from "@/Event";

    import Subscription from '../../../store/orm/Subscription'

    export default {
        name: "CreateRentButton",
        props: {
            id: {
                type: Number,
                required: true
            }
        },
        computed: {
            subscription() {
                return Subscription.find(this.id)
            }
        },
        methods: {
            createRent() {
                EventBus.$emit('createrent', this.id)

            }
        }
    }
</script>

<style scoped>

</style>
