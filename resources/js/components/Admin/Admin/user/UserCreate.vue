<template>
    <app-content>


        <template slot="toolbar">
            <v-toolbar-title>
                Nieuwe gebruiker

            </v-toolbar-title>
        </template>
        <template slot="text">
            <ontlener-component></ontlener-component>
        </template>


    </app-content>

</template>

<script>
    import ontlenerComponent from './create/OntlenerComponent'
    import vrijwilligerComponent from './create/VrijwilligerComponent'
    import appContent from '../basis/content'

    export default {
        name: "UserCreate",
        data() {
            return {
                active: 'onlenerComponent'

            }
        },
        computed: {
            issuperadmin() {
                return this.$store.getters['entities/users/userHasRole']('superadmin')
            },
            tabitems() {
                if (this.issuperadmin) {
                    return [{
                        tab: 'Nieuwe ontlener',
                        component: 'ontlenerComponent'
                    }, {
                        tab: 'Nieuwe vrijwilliger',
                        component: 'vrijwilligerComponent'
                    }]
                } else {
                    return [{
                        tab: 'Nieuwe ontlener',
                        component: 'ontlenerComponent'
                    }]
                }

            }

        },
        components: {
            ontlenerComponent,
            vrijwilligerComponent,
            appContent
        }
    }
</script>

<style scoped>
</style>
