<template>
    <app-content>

            <template slot="toolbar" >
                <v-toolbar-title>
                    Nieuwe Vrijwilliger

                </v-toolbar-title>
            </template>
        <template slot="text">
            <volunteer-component/>

        </template>


    </app-content>
</template>

<script>
    import volunteerComponent from '../user/create/VrijwilligerComponent'
    import appContent from '../basis/content'
    export default {
        name: "VolunteerCreate",
        components:{
            volunteerComponent,
            appContent
        }

    }
</script>

<style scoped>

</style>
