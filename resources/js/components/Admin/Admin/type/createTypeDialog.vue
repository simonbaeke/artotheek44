<template>
    <v-dialog v-model="dialog" persistent hide-overlay width="50%" transition="dialog-bottom-transition" xs6>
        <v-card>
            <v-card-title>
                <span class="headline">Nieuwe discipline</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm7 md7>
                            <v-text-field
                                    v-on:keydown="form.clearError('name')"
                                    :error-messages="form.error('name')"
                                    :error="form.hasError('name')"
                                    v-model="form.name"
                                    label="Naam">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm7 md7>
                            <v-text-field
                                    v-on:keydown="form.clearError('type_code')"
                                    :error-messages="form.error('type_code')"
                                    :error="form.hasError('type_code')"
                                    v-model="form.type_code"
                                    label="Typenummer">
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn  :loading="saving" flat @click.native="saveType">Opslaan</v-btn>

                <v-btn  flat @click.native="$emit('close')">Annuleren</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {Form} from "../../../Form.js"


    export default {
        name: "createTypeDialog",
        props: ['dialog'],
        data() {
            return {
                form: new Form({
                    name: "",
                    type_code:""
                }),
                saving: false,
            }
        },
        computed: {
            post() {
                return {
                    name: this.form.name,
                    type_code:this.form.type_code
                }
            }
        },
        methods: {
            saveType() {
                this.saving = true;
                this.$store.dispatch('createType', this.post).then(response => {
                    this.$emit('close');
                    this.saving = false;
                    this.form.clearErrors();
                    this.form.reset()
                }).catch(error => {
                    console.log(error)
                    this.saving = false;
                    this.form.setErrors(error);
                })
            },
        }
    }
</script>

<style scoped>

</style>
