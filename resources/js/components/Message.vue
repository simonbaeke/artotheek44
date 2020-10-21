<template>
    <div></div>
</template>

<script>
    import {EventBus} from "../Event";

    export default {
        name: "Message",
        props: ['message'],
        mounted() {
            EventBus.$emit('message', {
                component: 'notificationSnackbar',
                message: this.message,
                type:'success'
            })
        }

    }
</script>

<style scoped>

</style>
