<template>
    <app-content>
        <template slot="toolbar">
            <v-flex xs6>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        prepend-icon=""
                        label="Zoek vrijwilliger"
                        single-line
                        hide-details
                ></v-text-field>
            </v-flex>
            <v-spacer>

            </v-spacer>
            <v-btn text v-on:click="$router.push({name:'volunteercreate'})">Nieuwe vrijwilliger</v-btn>

        </template>

        <template slot="text">
            <v-data-table
                    :headers="headers"
                    :loading="loading"
                    :search="search"
                    :items="volunteers">
                <template v-slot:body="{ items }">
                    <tbody>
                    <volunteer-list-item v-for="(item,index) in items" :key="index" :volunteer="item"/>
                    </tbody>

                </template>

                <template v-slot:item.actions="{ item }">
                    <v-btn icon
                           :loading="deleting"
                    >
                        <v-icon
                                small
                                @click="deleteItem(item)"

                        >
                            mdi-delete
                        </v-icon>
                    </v-btn>
                </template>
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

            </v-data-table>

        </template>

    </app-content>
</template>

<script>
    import User from "../../../store/orm/User";
    import RoleUser from "../../../store/orm/RoleUser"
    import appContent from '../basis/content'
    import {EventBus} from "../../../Event";
    import volunteerListItem from '../volunteers/VolunteerListItem'

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
                    },
                    {
                        text:'beheerder',
                        sortable:false
                    }
                    , {
                        text: 'Verwijderen',
                        sortable: false,
                        value: 'actions'
                    }
                ],
                loading: false,
                deleting: false,
                search:""
            }

        },
        computed: {
            volunteers() {
                return User.query().whereHas('roles', (query) => {
                    query.where('name', 'vrijwilliger')

                }).with('roles').get()
            }
        },
        methods: {
            deleteItem(item) {
                this.deleting = true;
                axios.post('/api/roles/remove/' + item.id, {
                    role: 'vrijwilliger'
                })
                    .then((response) => {
                        let roleUser = RoleUser.query().where('role_id', 4)
                            .where('user_id', item.id).first()
                        roleUser.$delete()

                        User.insertOrUpdate({
                            data: response.data.data
                        })


                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Vrijwilliger verwijderd',
                            type: 'success'
                        })
                    }).catch((error) => {
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'vrijwiliger niet verwijderd ' + error,
                        type: 'error'
                    }).finally(() => {
                        this.loading = false
                    })
                })
            }
        },
        components: {
            appContent,
            volunteerListItem
        },
        mounted() {
            if (this.volunteers.length == 0) {
                this.loading = true
            }
            User.dispatch('fetch', {role: 'vrijwilliger'}).finally(() => this.loading = false)


        }
    }
</script>

<style scoped>

</style>
