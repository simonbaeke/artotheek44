<template>
    <v-dialog v-model="dialog" persistent hide-overlay width="50%" transition="dialog-bottom-transition" xs6>
        <v-card>
            <v-card-title>
                <span class="headline">Nieuwe Artist</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm7 md7>
                            <v-text-field
                                    v-on:keydown="form.clearError('firstname')"
                                    :error-messages="form.error('firstname')"
                                    :error="form.hasError('firstname')"
                                    v-model="form.firstname"
                                    label="Voornaam">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm7 md7>
                            <v-text-field
                                    v-on:keydown="form.clearError('lastname')"
                                    :error-messages="form.error('lastname')"
                                    :error="form.hasError('lastname')"
                                    v-model="form.lastname"
                                    label="Familienaam">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm7 md7>
                            <v-text-field
                                    v-on:keydown="form.clearError('short')"
                                    :error-messages="form.error('short')"
                                    :error="form.hasError('short')"
                                    v-model="form.short"
                                    label="Afkorting">
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="accent" flat @click.native="$emit('close')">Close</v-btn>
                <v-btn color="accent" :loading="saving" flat @click.native="saveArtist">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {Form} from "../../../Form.js"


    export default {
        name: "createArtistDialog",
        props: ['dialog'],
        data() {
            return {
                form: new Form({
                    firstname: "",
                    lastname: "",
                    short:""
                }),
                saving: false,

            }
        },
        computed: {
            post(){
                return{
                    firstname:this.form.firstname,
                    lastname:this.form.lastname,
                    short:this.form.short
                }
            }
        },
        methods: {
            saveArtist() {
                this.saving = true;
                this.$store.dispatch('createArtist', this.post).then(response => {
                    this.$emit('close',response.data.data.id);
                    this.saving = false;
                    this.form.clearErrors();
                    this.form.reset()
                }).catch(error => {
                    this.saving = false;
                    this.form.setErrors(error);
                })
            },
        }
    }
</script>

<style scoped>

</style>
