<template>
    <v-flex xs12 md6>
        <span class="grey--text">Kunstwerk huren</span>
        <v-layout row wrap>
            <v-flex xs8 >
                <v-autocomplete
                        :items="artworks"
                        item-text="fullname"
                        item-value="id"
                        label="Kunstwerk"
                        v-model="newRent.artwork_id"
                ></v-autocomplete>
            </v-flex>

            <v-flex xs4>
                <v-btn :loading="saving" outline @click.native="saveRent">Opslaan</v-btn>

            </v-flex>
        </v-layout>


    </v-flex>

</template>

<script>
    import User from "@/store/orm/User";
    import Rent from "@/store/orm/Rent";
    import {EventBus} from "@/Event";

    export default {
        name: "CreateRentComponent",
        props: ['subscription'],
        data() {
            return {
                newRent: {
                    artwork_id: ""
                },
                saving: false
            }
        },
        methods: {
            saveRent() {
                this.saving = true
                Rent.dispatch('createRent', {
                    subscription_id: this.subscription.id,
                    artwork_id: this.newRent.artwork_id
                }).then(response => {
                    EventBus.$emit('showorder')

                    this.saving = false
                }).catch(error => {
                    this.saving = false
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: error.response.data.message,
                        type: 'error'
                    })
                })
            }
        },
        computed: {
            artworks() {
                return this.$store.getters['entities/artworks/availableArtworks']
            },
            user() {
                return User.find(this.subscription.user_id)
            }

        }
    }
</script>

<style scoped>
</style>
