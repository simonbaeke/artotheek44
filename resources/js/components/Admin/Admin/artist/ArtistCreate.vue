<template>
    <app-content>

        <template slot="toolbar">
            <v-toolbar-title>Nieuwe artiest</v-toolbar-title>
            <v-spacer/>
            <v-btn
                    flat

                    v-on:click="storeArtist">Opslaan
            </v-btn>
            <v-btn flat v-on:click="$router.push({name:'artistlist'})">Terug</v-btn>
        </template>

        <template slot="text">
            <v-form>
                <v-container>
                    <v-layout row wrap>
                        <v-flex xs12 md4>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-text-field
                                            v-on:keydown="form.clearError('firstname')"
                                            :error-messages="form.error('firstname','Voornaam')"
                                            :error="form.hasError('firstname')"
                                            v-model="form.firstname"
                                            label="voornaam">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                            v-on:keydown="form.clearError('lastname')"
                                            :error-messages="form.error('lastname','Familienaam')"
                                            :error="form.hasError('lastname')"
                                            v-model="form.lastname"
                                            label="familienaam">
                                    </v-text-field>
                                </v-flex>
                                <v-flex xs12>
                                    <v-text-field
                                            v-on:keydown="form.clearError('short')"
                                            :error-messages="form.error('short','Afkorting')"
                                            :error="form.hasError('short')"
                                            v-model="form.short"
                                            label="Afkorting">
                                    </v-text-field>
                                </v-flex>
                            </v-layout>

                        </v-flex>

                        <v-flex xs12 md8>
                            <v-textarea
                                    auto-grow
                                    v-on:keydown="form.clearError('bio')"
                                    :error-messages="form.error('bio','Biographie')"
                                    :error="form.hasError('bio')"
                                    v-model="form.bio"
                                    label="Biographie">
                            </v-textarea>
                        </v-flex>


                    </v-layout>
                </v-container>


            </v-form>
            <v-divider></v-divider>
            <v-card-actions>
                <v-item-group>

                </v-item-group>
            </v-card-actions>
        </template>


    </app-content>

</template>

<script>
    import {Form} from "@/Form";
    import Artist from "@/store/orm/Artist";
    import appContent from '../basis/content'

    export default {
        name: "ArtistCreate",
        data() {
            return {
                form: new Form({
                    firstname: '',
                    lastname: '',
                    short: '',
                    bio: ''
                })
            }
        },
        methods: {
            storeArtist() {
                Artist.dispatch('createArtist', {
                    firstname: this.form.firstname,
                    lastname: this.form.lastname,
                    short: this.form.short,
                    bio: this.form.bio
                })
            },
        },
        components: {
            appContent
        }
    }
</script>

<style scoped>

</style>
