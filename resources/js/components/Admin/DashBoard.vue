x<template>
    <v-content>
        <v-container>
            <v-layout>
                <v-flex>
                    <router-view></router-view>
                    <v-flex class="alert-container">
                        <app-alert></app-alert>
                    </v-flex>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>

</template>

<script>
    import appAlert from '../Alert.vue'
    import User from '../../store/orm/User'

    export default {
        name: "DashBoard",

        created() {

        },
        components: {
            appAlert
        },
    }
</script>


<style scoped>

</style>
