<template>
    <div>
        <v-flex xs12>
            <span class="headline">Kunstwerk huren</span>
            <v-layout row wrap class="mx-6">
                <v-flex xs12 md12>
                    <v-switch v-model="switch1" :label="switchLabel"></v-switch>
                </v-flex>
                <v-flex xs12 md4 v-if="switch1">
                    <v-autocomplete
                            dense
                            :items="artworks"
                            item-text="fullname"
                            item-value="id"
                            label="Kunstwerk"
                            v-model="newRent.artwork_id"
                            :loading="loading"
                    ></v-autocomplete>
                </v-flex>
                <v-flex xs12 md4 v-if="!switch1">
                    <v-text-field
                            v-model="code"
                            label="Code"
                    />
                </v-flex>

                <v-flex xs12 md8>
                    <v-btn class="float-right" outlined :loading="saving" @click.native="saveRent">Opslaan</v-btn>
                </v-flex>
            </v-layout>


        </v-flex>

        <force-rent-dialog
                :dialog="unavailable"
                :code="code"
                v-on:close="closeDialog"

        >

        </force-rent-dialog>
    </div>


</template>

<script>
    import User from "../../../store/orm/User";
    import Rent from "../../../store/orm/Rent";
    import Artwork from "../../../store/orm/Artwork";
    import Subscription from "../../../store/orm/Subscription";
    import {EventBus} from "../../../Event";
    import ConfirmDialog from '../dialog/ConfirmDialog';
    import ForceRentDialog from '../rent/ForceRentDialog';

    export default {
        name: "CreateRentComponent",
        props: {
            subscription: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                newRent: {
                    artwork_id: ""
                },
                saving: false,
                switch1: true,
                code: "",
                unavailable: false,
                forcing: false,
                activeRent: null,
                loading: false,
            }
        },
        methods: {
            saveRent() {
                this.saving = true
                Rent.dispatch('createRent', {
                    subscription_id: this.subscription.id,
                    artwork_id: this.newRent.artwork_id,
                    type: this.switchLabel,
                    artwork_code: this.code
                }).then(response => {

                    this.$router.push({name: 'userdetail', params: {id: response.data.data.user.id, tab: 2}})

                    EventBus.$emit('showorder')


                    Subscription.dispatch('fetchSubscriptionById', response.data.data.subscription_id)

                    this.saving = false

                }).catch(error => {
                    this.saving = false

                    if (error.response.data.message == 'Kunstwerk niet beschikbaar') {
                        this.unavailable = true
                    }
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: error.response.data.message,
                        type: 'error'
                    })
                })
            },
            closeDialog() {
                this.unavailable=false
            }
        },
        computed: {
            artworks() {
                return this.$store.getters['entities/artworks/availableArtworks']
            },
            user() {
                return User.find(this.subscription.user_id)
            },
            switchLabel() {
                if (this.switch1) {
                    return 'Titel'
                }

                return 'Code'
            }


        },
        watch: {
            unavailable() {
                if (this.unavailable) {
                    //fetch active rent


                }
            }
        },
        mounted() {
            this.loading = true
            Artwork.dispatch('fetchArtworks', {'available': true}).then(e => {
                this.loading = false
            })

        },
        components: {
            ConfirmDialog,
            ForceRentDialog

        }
    }
</script>

<style scoped>
</style>
