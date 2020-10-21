<template>
    <app-content>
            <template slot="toolbar">
                <v-flex xs6>
                    <v-text-field
                            v-model="search"
                            append-icon="search"
                            label="Zoek lid"
                            single-line
                            hide-details
                    ></v-text-field>
                </v-flex>
                <v-spacer></v-spacer>

                <v-btn text v-on:click="$router.push({name:'usercreate'})">Nieuw lid toevoegennn</v-btn>


            </template>
            <template slot="text">
                <v-card text>
                    <v-data-table
                            light
                            :headers="headers"
                            :items="users"
                            :loading="loading"
                            :search="search"

                            hide-default-footer
                            no-results-text="Niemand gevonden"
                    >

                        <template v-slot="item" slot-scope="props" v-if="!loading">
                            <tr>
                                <router-link tag="td" :to="{ name: 'userdetail', params: { id: props.item.id }}">{{
                                    props.item.fullname }}
                                </router-link>
                                <router-link tag="td" :to="{ name: 'userdetail', params: { id: props.item.id }}">{{
                                    props.item.id }}
                                </router-link>
                            </tr>
                        </template>
                    </v-data-table>

                </v-card>
            </template>

    </app-content>


</template>

<script>
    import User from "@/store/orm/User";
    import appContent from '../basis/content'

    export default {
        data() {
            return {

                page: 1,
                itemsPerPage: 10,

                search: "",
                headers: [
                    {
                        text: 'Naam',
                        align: 'left',
                        sortable: true,
                        value: 'fullname'
                    }   ,
                    {text: 'Email', sortable: false, value: 'email'},
                ],
                //rowsPerPage: [10]
                //rowsPerPage: [10, 25, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 } ]
            }
        },
        computed: {
            users() {
                return User.query().whereHas('roles',(query)=>{
                    query.where('name','ontlener')
                }).get()

                return this.$store.getters['entities/users/users'].filter(user => {
                    return user.id !== this.user.id
                })
            },
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            },
            loading() {
                return User.getters('loading')
            }
        },
        components:{
            appContent
        }

    }
</script>


<style scoped>
    .nv-toolbar {
        background-image: linear-gradient(rgba(0, 184, 148, 0.38), #00b894);
    }
</style>

