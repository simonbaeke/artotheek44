<template>
    <v-container
            v-if="show"
            :timeout="1000"
            color="white"
            multi-line
    >
        {{ text }}
        <v-btn
                color="white"
                flat
                @click="close"
        >
            sluit
        </v-btn>
        <v-btn color="white" flat v-on:click="requestSend">
            Zend email opnieuw
        </v-btn>

    </v-container>
</template>

<script>
    import {EventBus} from "../Event";

    export default {
        name: "VerifiedSnackbar",
        props: ['message', 'index'],
        data() {
            return {
                show: true,
                timeout: 0,
                text: 'Uw email adres is nog niet geverifieerd'
            }
        },
        methods: {
            requestSend() {
                this.close()
                axios.get('api/email/resend')
                    .then(response => {
                        EventBus.$emit('message',{
                        component:'notificationSnackbar',
                        message:'Er is een nieuwe bevestigingsmail verzonden, deze is 1 uur geldig',
                        type:'info'
                    })
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            close(){
                this.$emit('close',this.index)
            }
        }
    }
</script>

<style scoped>
    .container {
        width: 100%;
        background-color: orange;
        color: white;
        padding: 1rem 2rem;
    }

    @media only screen and (min-width: 600px) {
        .container {
            width: 100%;
            max-width: 100% !important;

        }
    }
</style>
