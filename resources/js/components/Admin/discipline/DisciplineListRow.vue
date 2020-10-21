<template>
    <tr>
        <td>
            <v-dialog v-model="dialog" persistent max-width="600px">
                <template slot="activator">
                    <span color="primary" dark>{{type.name}}</span>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">Wijzig naam van discipline</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm6 md4>
                                    <v-text-field
                                            v-model="form.name"
                                            label="Naam"
                                            required/>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn :loading="updating" flat @click="save">Opslaan</v-btn>
                        <v-btn :disabled="updating" flat @click="close">Annuleren</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </td>
        <td>
            <v-dialog v-model="codeDialog" persistent max-width="600px">
                <template slot="activator">
                    <span color="primary" dark>{{type.code}}</span>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">Wijzig nummer van discipline</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm6 md4>
                                    <v-text-field
                                            v-model="form.type_code"
                                            label="Nummer"
                                            required/>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn :loading="updating" flat @click="save">Opslaan</v-btn>
                        <v-btn :disabled="updating" flat @click="close">Annuleren</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </td>

    </tr>
</template>

<script>
    import {Form} from "../../../Form";
    import Type from "../../../store/orm/Type";

    export default {
        name: "DisciplineListRow",
        props: {
            type: {required: true}
        },
        data() {
            return {
                dialog: false,
                codeDialog: false,
                form: new Form({
                    name: this.type.name,
                    type_code: this.type.code,
                    id: this.type.id
                }),
                updating: false,
            }
        },
        watch: {
            dialog() {
                if (this.dialog) {
                    this.form.name = this.type.name
                    this.form.code = this.type.code
                    this.form.id = this.type.id
                }
            }
        },
        methods: {
            save() {
                this.updatetingName = true
                Type.dispatch('updateType', this.form.data()).then(response => {
                    this.updatetingName = false
                    this.close()
                })
            },
            close() {
                this.dialog = false
                this.codeDialog = false
            }
        }
    }
</script>

<style scoped>

</style>
