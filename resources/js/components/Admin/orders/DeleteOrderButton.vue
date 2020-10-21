<template>
    <v-btn
            fab
            small
            text
            :loading="deleting"
            v-on:click.native="deleteOrder()"
    >
        <v-icon>delete_outline</v-icon>
    </v-btn>
</template>

<script>
    import Order from '../../../store/orm/Order'

    export default {
        name: "DeleteOrderButton",
        props: {
            id: {
                required: true
            }
        },
        data() {
            return {
                deleting: false
            }
        },
        methods: {
            deleteOrder() {
                this.deleting = true
                Order.dispatch('destroy', {id: this.id})
                    .then(() => {
                        this.deleting = false
                    })
                    .catch(() => {

                    })
            }
        }
    }
</script>

<style scoped>

</style>
