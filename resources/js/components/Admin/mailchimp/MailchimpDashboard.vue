<template>
    <app-main>
        <template slot="title">
            Mailchimp
        </template>
        <template slot="content">
            <app-content>

                <template slot="toolbar">
                    Dashboard
                    <v-spacer/>
                    <mailchimp-modal/>
                </template>
                <template slot="text">
                   <add-to-Mailchimp type="ontlener">
                       <template slot="text">Voeg alle huidige gebruikers toe aan mailchimp</template>
                   </add-to-Mailchimp>
                </template>
            </app-content>


        </template>

    </app-main>
</template>

<script>
    import appMain from '../basis/main'
    import addToMailchimp from './button/addVrijwilliger'
    import appContent from '../basis/content'
    import mailchimpModal from '../mailchimp/MailchimpConfigModal'

    export default {
        name: "MailchimpDashboard",
        computed:{
            users(){
                return User.query().whereHas('roles', (query) => {
                    query.where('name', 'vrijwilliger')

                }).with('roles').get()
            }
        },
        methods: {
            addToMailchimp(tag) {

            }
        },
        components: {
            appMain,
            appContent,
            addToMailchimp,
            mailchimpModal
        },

    }

</script>

<style scoped>

</style>
