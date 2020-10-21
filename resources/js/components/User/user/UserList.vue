<template>

    <v-app>
        <v-card>
            <v-card-title>
                Gebruikers
                <v-spacer></v-spacer>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="users"
                    :pagination.sync="pagination"
                    :total-items="totalUsers"
                    :loading="api.loading"
                    class="elevation-1"
            >
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="props">
                    <td v-on:click="showDetails(props.item)">{{ props.item.firstname }}</td>
                    <td v-on:click="showDetails(props.item)">{{ props.item.lastname}}</td>
                </template>
            </v-data-table>
        </v-card>
    </v-app>


</template>

<script>
    import {Api} from "../../../Api";
    import {eventBus} from "../../../app";

    export default {
        data() {
            return {
                pagination: {
                    descending: true,
                    page: 1,
                    rowsPerPage: 10,// -1 for All
                    sortBy: 'expires',

                },
                search: "",
                api: new Api(),
                totalUsers: 0,
                headers: [
                    {
                        text: 'Voornaam',
                        align: 'left',
                        sortable: false,
                        value: 'firstname'
                    },
                    {text: 'Familienaam', sortable: false, value: 'lastname'}
                ]
            }
        },
        computed: {
            queryData() {
                return {
                    page: this.pagination.page,
                    rowsPerPage: this.pagination.rowsPerPage,// -1 for All
                    totalItems: this.totalItems,
                    search: this.search
                }
            },
        },
        watch: {
            pagination: {
                handler() {
                    this.getDataFromApi();
                },
                deep: true
            }
        },
        created() {
            this.getDataFromApi();

        },
        methods: {
            getDataFromApi() {
                this.api.get('/users', {
                    params: this.queryData
                })
                    .then(data => {
                        this.loading = false;
                        this.totalUsers = data.meta.total;
                    })
            },
            showDetails(item) {
                this.$router.push({name: 'userdetail', params: {id: item.id}});
            }
        }
    }
</script>
