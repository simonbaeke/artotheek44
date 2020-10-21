<template>
    <app-content>
        <template slot="toolbar">
            <v-toolbar-title>Wijzig artiest</v-toolbar-title>
            <v-spacer/>
            <v-btn
                    text

                    v-on:click="editArtist">Opslaan
            </v-btn>
            <v-btn text v-on:click="$router.push({name:'artistdetail',params:{id:$route.params.id}})">Terug
            </v-btn>
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
            <v-card-actions>
                <v-item-group>
                    <v-btn
                            text

                            v-on:click="editArtist">Opslaan
                    </v-btn>
                    <v-btn text v-on:click="$router.push({name:'artistdetail',params:{id:$route.params.id}})">Terug
                    </v-btn>
                </v-item-group>
            </v-card-actions>
        </template>

        <v-divider></v-divider>

    </app-content>

</template>

<script>
    import {Form} from "../../../Form";
    import Artist from "../../../store/orm/Artist"
    import appContent from '../basis/content'
import {EventBus} from "../../../Event";

    export default {
        name: "ArtistEdit",

        data() {
            return {
                form: new Form({
                    firstname: '',
                    lastname: '',
                    bio: '',
                    short: ''
                })
            }
        },
        methods: {
            editArtist() {
                Artist.dispatch('editArtist', {
                    id: this.$route.params.id,
                    artist: {
                        firstname: this.form.firstname,
                        lastname: this.form.lastname,
                        bio: this.form.bio,
                        short: this.form.short
                    }
                }).then(response => {
                    this.$router.push({name: 'artistdetail', params: {id: this.$route.params.id}})
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Kunstenaar gewijzigd',
                        type:'success'
                    })
                })

            }
        },
        computed: {
            artist() {
                return Artist.find(this.$route.params.id)
            }
        },
        mounted() {

                if (this.artist == null){
                    Artist.dispatch('fetchArtist',this.$route.params.id).then(response=>{
                        this.form.firstname = this.artist.firstname
                        this.form.lastname = this.artist.lastname
                        this.form.short = this.artist.short
                        this.form.bio = this.artist.bio
                    })
                }else{
                    this.form.firstname = this.artist.firstname
                    this.form.lastname = this.artist.lastname
                    this.form.short = this.artist.short
                    this.form.bio = this.artist.bio
                }




        },
        components: {
            appContent
        }
    }
</script>

<style scoped>

</style>
