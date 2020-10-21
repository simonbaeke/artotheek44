<template>
    <v-app>
        <v-subheader>
            <h1 class="mr-3 blue--text">Verkoop Kunstwerk</h1>
        </v-subheader>
        <v-card text>
            <v-toolbar text color="lime lighten-2">
                <v-toolbar-title>{{artwork.name}}</v-toolbar-title>
                <v-spacer/>
                <v-item-group>

                </v-item-group>
            </v-toolbar>
            <v-card-text>
                <v-form>
                    <v-container>
                        <v-layout row wrap>
                            <v-flex xs-12>
                                <span class="grey--text">
                                    Prijs: {{artwork.price}} Euro
                                </span>
                            </v-flex>
                            <v-flex xs12>
                                <v-switch
                                        v-model="knownUser"
                                        label="Koper in database"
                                        hide-details
                                        v-on:change="selectedUser=''"
                                ></v-switch>
                            </v-flex>
                        </v-layout>
                        <v-card text>
                            <v-card-title>Koper</v-card-title>
                            <v-card-text>
                                <component
                                        :is="selectedComponent"
                                        v-on:change="selectedUser=$event"
                                />
                            </v-card-text>
                            <v-card-actions>
                                <v-btn
                                       :disabled="!valid"
                                       text :loading="selling"
                                       @click="save">
                                    Opslaan
                                </v-btn>
                                <v-btn text @click="$emit('cancel')">Annuleren</v-btn>
                            </v-card-actions>
                        </v-card>

                    </v-container>
                </v-form>
            </v-card-text>
        </v-card>

    </v-app>

</template>

<script>
    import selectKnownUser from './SelectKnownUserComponent'
    import unknownUser from './unknownUserComponent'

    export default {
        name: "ArtworkSale",
        props: {
            artwork: {
                required: true
            }
        },
        data() {
            return {
                knownUser: true,
                selling: false,
                selectedUser: ""
            }
        },
        computed: {
            selectedComponent() {
                return this.knownUser ? 'selectKnownUser' : 'unknownUser'
            },
            valid(){
                return this.selectedUser != ""
            }
        },
        methods: {
            save() {
                axios.post('api/sale', {
                    artwork_id: this.artwork.id,
                    user_id:this.knownUser? this.selectedUser:"",
                    user_info: this.knownUser?"" : this.selectedUser
                })

            }
        },
        components: {
            selectKnownUser,
            unknownUser
        }
    }
</script>

<style scoped>

</style>
