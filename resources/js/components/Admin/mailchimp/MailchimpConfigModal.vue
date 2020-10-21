<template>
    <v-dialog v-model="dialog" persistent max-width=315>
        <template v-slot:activator="{ on }">
            <v-btn color="lime" text light v-on="on">
                <v-icon color="black">settings</v-icon>
            </v-btn>
        </template>
        <mailchimp-config
                v-on:close="dialog=false"
        />
    </v-dialog>
</template>

<script>
    import mailchimpConfig from '../mailchimp/MailchimpConfig'
    export default {
        name: "MailchimpConfigModal",

        data(){
            return{
                dialog:false
            }
        },
        components:{
            mailchimpConfig
        }
    }
</script>

<style scoped>

</style>
