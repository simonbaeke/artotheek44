<template>
    <app-content>

        <template slot="toolbar">
            <v-toolbar-title>
                Nieuwe Vrijwilliger

            </v-toolbar-title>
        </template>
        <template slot="text">

            <v-switch v-model="isUser"
                      :label="isUser? 'Nieuwe vrijwilliger is reeds gebruiker: Ja' : 'Nieuwe vrijwilliger is reeds gebruiker:  Nee'"></v-switch>


            <div v-if="!isUser">
                <volunteer-component
                        v-bind:ontlener="false"
                        v-bind:vrijwilliger="true"
                        v-bind:back="volunteerlist"
                />
            </div>

            <div v-if="isUser">
                <create-existing-volunteer
                        :loading="saving"
                />
            </div>


        </template>


    </app-content>
</template>

<script>
    import volunteerComponent from '../user/create/OntlenerComponent'
    import createExistingVolunteer from '../volunteers/createExistingVoluntueer'
    import appContent from '../basis/content'
    import {EventBus} from "../../../Event";
    import User from '../../../store/orm/User'

    export default {
        name: "VolunteerCreate",
        components: {
            volunteerComponent,
            appContent,
            createExistingVolunteer
        }, data() {
            return {
                isUser: false,
                volunteerlist: "volunteerlist",
                saving: false
            }
        },
        created() {
            EventBus.$on('vrijwilliger aangemaakt', (data) => {
                this.saving = true
                axios.post('/api/roles/assign/' + data, {
                    role: 'vrijwilliger'
                })
                    .then((response) => {
                        User.insertOrUpdate({
                            data: response.data.data
                        })

                        this.saving = false
                        this.$router.push({name: 'volunteerlist'})

                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Nieuwe vrijwilliger aangemaakt',
                            type: 'success'
                        })
                    }).catch((error) => {
                    this.saving = false
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'vrijwiliger niet aangemaakt ' + error,
                        type: 'error'
                    })
                })
            })
        }

    }
</script>

<style scoped>

</style>
