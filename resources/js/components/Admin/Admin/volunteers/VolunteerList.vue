<template>
    <app-content>
        <template slot="toolbar">
            <v-toolbar-title>
                Alle vrijwilligers op een rijtje
            </v-toolbar-title>
            <v-spacer>

            </v-spacer>
            <v-btn flat v-on:click="$router.push({name:'volunteercreate'})">Nieuwe vrijwilliger</v-btn>

        </template>

        <template slot="text">
            <v-data-table
                    :headers="headers"
                    :loading="loading"
                    :items="volunteers">
                <template slot="items" slot-scope="props" v-if="!loading" v-on:click="alert('alert')">
                    <tr>
                        <router-link tag="td" :to="{ name: 'volunteerdetail', params: { id: props.item.id }}">{{
                            props.item.fullname }}
                        </router-link>
                        <router-link tag="td" :to="{ name: 'volunteerdetail', params: { id: props.item.id }}">{{
                            props.item.email }}
                        </router-link>
                    </tr>
                </template>
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

            </v-data-table>

        </template>

    </app-content>
</template>

<script>
    import User from "@/store/orm/User";
    import appContent from '../basis/content'

    export default {
        name: "VolunteerList",
        data() {
            return {
                headers: [
                    {
                        text: 'Naam',
                        align: 'left',
                        sortable: true,
                        value: 'fullname'
                    },
                    {
                        text: 'Email',
                        align: 'left',
                        sortable: true,
                        value: 'email'
                    }
                ],
                loading: false
            }

        },
        computed: {
            volunteers() {
                return User.query().whereHas('roles', (query) => {
                    query.where('name', 'admin')
                }).whereHasNot('roles', (query2) => {
                    query2.where('name', 'superadmin')
                }).with('roles').get()
            }
        },
        components: {
            appContent
        },
        mounted() {
            if (this.volunteers.length == 0) {
                this.loading = true
            }
            User.dispatch('fetch', {role: 'admin'}).finally(() => this.loading = false)


        }
    }
</script>

<style scoped>

</style>
