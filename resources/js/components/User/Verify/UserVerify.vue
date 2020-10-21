<template>
    <div style="margin-top:50px;">
        <v-container>
            <v-layout row wrap>

                <v-flex v-if="success && usermatch">
                    Uw email adres is succesvol geverifieerd
                </v-flex>

                <v-flex v-if="success && !usermatch">
                    Het email adres is succesvol geverifieerd, maar u kan niet ingelogd worden
                </v-flex>

                <v-flex xs12 md6 offset-md3 v-if="!success && usermatch" class="pa-3">
                    <v-alert type="error" value="true" icon="priority_high">
                        Uw email adres is NIET succesvol geverifieerd omdat de verificatielink niet meer geldig is.
                        klik op de knop hieronder zodat ons team u zo snel als mogelijk een nieuwe email
                        kan toesturen
                        <v-divider class="mt-2"></v-divider>
                        <v-btn flat small v-on:click="requestSend">Zend opnieuw</v-btn>
                    </v-alert>
                </v-flex>



                <v-flex v-if="!usermatch && !success">Er is geen emailadres geverifieerd ,Niet correct ingelogd</v-flex>


            </v-layout>
        </v-container>
    </div>

</template>

<script>
    import {EventBus} from "../../../Event";

    export default {
        name: "UserVerify",
        data() {
            return {
                success: this.$route.query.success == "true",
                failed: false
            }
        },
        methods: {
            requestSend() {
                axios.get('/email/resend')
                    .then(response => {

                        console.log('resend successs')
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },
        watch: {
            user(){
                if(this.user.id>-1){
                    EventBus.$emit('message',{
                        component:'notificationSnackbar',
                        message:'Emailadres is bevestigd'
                    })
                    this.$router.push({name:'landing'})
                }
            }
        },
        computed: {
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            },
            usermatch() {
                return this.$store.getters['entities/users/loggedInUser'].id == this.$route.query.id
            }
        }
    }
</script>

<style scoped>

</style>
