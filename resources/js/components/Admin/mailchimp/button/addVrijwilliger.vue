<template>
    <div>
        <v-btn
                :loading="loading"
                @click="addToMailchimp">
            <slot name="text"></slot>
        </v-btn>

        <v-card
                class="elevation-0"
                max-width="500"
        >
            <v-sheet class="pa-4 primary lighten-2">
                <v-text-field
                        v-model="search"
                        label="Zoek gebruiker in mailchimp"
                        dark
                        flat
                        solo-inverted
                        hide-details
                        clearable
                        clear-icon="mdi-close-circle-outline"
                ></v-text-field>
            </v-sheet>
            <v-card-text>
                <v-treeview
                        :items="items"
                        :search="search"
                        :open.sync="open"
                >
                    <template v-slot:prepend="{ item }">
                        <v-icon
                                v-text="person"
                        ></v-icon>
                    </template>
                </v-treeview>
            </v-card-text>
        </v-card>
    </div>

</template>

<script>
    import User from '../../../../store/orm/User'

    export default {
        name: "addVrijwilliger",
        props: {
            type: {
                required: true
            }
        },
        data() {
            return {
                adding: false,
                loading: false,
                responses: [],
                items: [],
                search: ""
            }
        },
        methods: {
            addToMailchimp() {
                axios.get('api/newsletter/subscribeall').then(response => {
                    console.log(response)


                })
            }
        },
        computed: {
            users() {
                return User.query().whereHas('roles', (query) => {
                    query.where('name', this.type)

                }).with('roles').get()
            }
        },
        mounted() {
            //User.dispatch('fetch').finally(() => this.loading = false)
            axios.get('api/newsletter/getmembers').then(response => {
                this.items = response.data.members.map(member => {
                    return {
                        id: member.id,
                        name: member.merge_fields.FNAME + " " + member.merge_fields.LNAME,
                        children: [
                            {
                                id: '23',
                                name: member.email_address,
                            },
                            {
                                id:'24',


                                children:
                                    [

                                        member.tags.map(tag => {
                                            return {
                                                id: tag.id,
                                                name: tag.name
                                            }
                                        })]
                            },

                        ]


                    }
                })
            })
        }
    }
</script>

<style scoped>

</style>
