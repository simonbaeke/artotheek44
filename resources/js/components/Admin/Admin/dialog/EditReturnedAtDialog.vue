<template>
    <v-dialog v-model="dialog" width="500">
        <v-card>
            <v-card-title>
                <span class="title"> Datum terugbezorging wijzigen</span>
            </v-card-title>
            <v-card-text>

                <v-layout row wrap>
                    <v-flex xs12>
                        <v-checkbox v-model="returned" label="Kunstwerk teruggebracht"/>
                    </v-flex>
                    <v-flex xs12 sm12 v-if="returned">
                        <v-menu
                                v-model="pickermenu"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <template slot="activator">
                                <v-text-field
                                        v-model="date"
                                        label="Datum terugbrengen kunstwerk"
                                        prepend-icon="event"
                                        readonly
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="date" @input="pickermenu = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-card-actions>
                <v-btn flat v-on:click="save">Opslaan</v-btn>

                <v-btn flat v-on:click="close">Annuleren</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script>

    import Rent from "../../../store/orm/Rent";

    export default {
        name: "EditReturnedAtDialog",
        props: {
            dialog: {
                required: true,
            },
            rent: {
                required: true
            }
        },
        data() {
            return {
                date: new Date(Date.now()).toISOString().substr(0, 10),
                returned: false,
                pickermenu: false
            }
        },
        computed: {
            returned_at() {
                if (this.returned) {
                    return this.date
                }

                return null
            }
        },
        watch: {
            dialog() {
                if (this.dialog) {
                    if (this.returned_at != null){
                        this.returned= true
                    }
                }


            }

        },
        methods: {
            save() {
                Rent.dispatch('updateRent', {
                    id: this.rent.id,
                    returned_at: this.returned_at
                }).then(response => {
                    this.close()
                }).catch(error => {
                    console.log(error)
                })

            },
            close() {
                this.$emit('close')
            }
        }

    }
</script>

<style scoped>

</style>
