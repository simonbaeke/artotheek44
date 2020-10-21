<template>
    <v-dialog v-model="dialog.dialog" persistent hide-overlay max-width="600px" transition="dialog-bottom-transition" xs6>
        <v-card v-if="dialog.dialog">
            <v-card-title>
                <span class="headline">Nieuwe ontlening</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-text-field
                                    label="Ontlener"
                                    readonly
                                    disabled
                                    v-model="fullname"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 md12>

                            <v-autocomplete
                                    :items="artworks"
                                    item-text="name"
                                    item-value="id"
                                    label="Kunstwerk"
                                    v-model="newRent.artwork_id"
                            ></v-autocomplete>
                        </v-flex>

                        <v-flex xs12 md12>
                            <expire-date-picker
                                    :subscription="subscription"
                                    v-on:datechange="newRent.expires=$event"
                            />

                        </v-flex>

                    </v-layout>
                </v-container>
            </v-card-text>
            <v-divider></v-divider>

            <v-card-actions>
                <v-btn flat @click.native="$emit('close')">Close</v-btn>
                <v-btn :loading="saving" flat @click.native="saveRent">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Artwork from '../../../store/orm/Artwork'
    import Subscription from '../../../store/orm/Subscription'
    import User from '../../../store/orm/User'
    import expireDatePicker from '../date/ExpireDatePicker'
    import {EventBus} from "@/Event";


    export default {
        name: "CreateRentDialog",
        props: {
            dialog: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                newRent: {
                    subscription_id: this.dialog.form.subscription_id,
                    artwork_id: "",
                    expires: this.dialog.form.expires,
                    returned_at: null
                },
                loading: false,
                date: new Date().toISOString().substr(0, 10),

                dateError: false,
                menu: false,
                saving: false,
            }
        },
        methods: {
            saveRent() {
                this.saving = true;
                this.newRent.subscription_id = this.dialog.form.subscription_id,
                this.$store.dispatch('createRent', this.newRent).then(response => {
                    this.$emit('close');
                    this.saving = false;
                    console.log(response)
                }).catch(error => {
                    this.saving = false;
                    //this.$store.commit('setError',error)
                })

            },
            fetchAvailableArtworks() {
                this.loading = true;
                this.$store.dispatch('fetchAvailableArtworks')
                    .then(response => {
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                        console.log(error)
                    })
            },
            today(){
                return new Date().toISOString().substr(0, 10)
            }
        },
        computed: {
            subscription(){
                return Subscription.find(this.dialog.form.subscription_id)
            },
            artworks() {
                return this.$store.getters['entities/artworks/availableArtworks']
            },
            fullname() {
                if(this.subscription){
                    let user = User.find(this.subscription.user_id)
                    return user.firstname + " " + user.lastname
                }
                return ""
            },
            maxdate(){
                if(this.subscription){
                    return this.subscription.expires
                }
                return ""
            }
        },

        mounted() {
            Artwork.dispatch('fetchArtworks', {status: "beschikbaar"})
        },
        created(){
            EventBus.$on('createrent',subscription => {
                this.newRent.subscription_id = subscription.id
                this.newRent.artwork_id = null
                EventBus.$emit('resetdate')
            })
        }
        ,
        components: {
            expireDatePicker
        }
    }
</script>

<style scoped>

</style>
