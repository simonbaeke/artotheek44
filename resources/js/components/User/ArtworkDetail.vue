dd<template>
    <v-dialog v-model="showDetail" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card v-if="artwork">
            <v-toolbar dark color="#044E7F">

                <v-toolbar-title>
                    <slot name="title"></slot>
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn icon dark @click.native="$emit('close')">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-container>
                <v-layout row wrap>
                    <v-flex xs12 :md12="fullscreen" :md6="!fullscreen">
                        <v-hover>

                            <v-scale-transition slot-scope="{ hover }">
                                <v-img
                                        :src="artwork.thumbnailurl"
                                        contain
                                        class="grey darken-4"
                                        color="white"

                                        :class="`elevation-${hover ? 12 : 2}`"


                                >
                                    <v-container hidden-sm-and-down
                                                 v-if="hover"
                                                 fill-height
                                                 fluid
                                                 pa-2
                                    >
                                        <v-layout fill-height>
                                            <v-flex xs12 align-end flexbox text-xs-right>
                                                <v-icon color="white" large v-on:click="fullscreen=!fullscreen">
                                                    {{fullscreenIcon}}
                                                </v-icon>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-img>
                            </v-scale-transition>

                        </v-hover>

                    </v-flex>
                    <v-flex xs12 md6 v-if="!fullscreen">
                        <v-card flat class="ml-5">
                            <v-card-title primary-title>
                                <div>
                                    <div class="headline">{{artwork.name}}</div>

                                    <div class="grey--text">{{fullname}}</div>
                                </div>
                            </v-card-title>
                            <v-card-text>
                                <div>
                                    <div v-bind:class="[artwork.available ? 'green--text' : 'red--text', 'help flex-end']">
                                        {{available}}
                                    </div>
                                    <div>{{artwork.type.name}}</div>
                                    <div>{{!artwork.forsale?'Niet te koop':'Te koop voor ' + artwork.price + '€'}}</div>
                                    <div>Afmetingen:
                                        hoogte: {{artwork.height/10}}cm,
                                        breedte: {{artwork.width/10}}cm,
                                        diepte: {{artwork.length/10}}cm
                                    </div>
                                </div>
                            </v-card-text>
                            <div v-if="user.id>-1">
                                <v-card-actions v-if="artwork.available">
                                    <reservation-button :artwork_id="artwork_id"/>
                                </v-card-actions>
                                <v-card-actions v-if="!artwork.available">
                                    <v-checkbox
                                            v-on:click.native="notify"
                                            color="primary"
                                            label="Verwittig indien beschikbaar"
                                            v-model="artwork.notify"
                                            :disabled="notifieng"
                                    ></v-checkbox>
                                </v-card-actions>
                            </div>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    import Artwork from '../../store/orm/Artwork'
    import reservationButton from './ReservationButton'

    export default {
        name: "ArtworkDetail",
        props: ['showDetail', 'artwork_id'],
        data() {
            return {
                fullscreen: false,
                notifieng: false
            }
        },
        methods: {
            notify() {

                this.notifieng = true;
                Artwork.dispatch('notify', {artwork_id: this.artwork.id})
                    .then(response => {
                        this.notifieng = false
                    })
                    .catch(error => {
                        this.notifieng = false
                    })
            },
            checkboxclick() {
                console.log('click')
            }
        },
        watch: {
            artwork_id() {



            }
        }
        ,
        computed: {
            artwork() {
                return Artwork.query().where('id', this.artwork_id).with('artist').with('type').first()
            },
            fullscreenIcon() {
                if (this.fullscreen) {
                    return "fullscreen_exit"
                }
                return "fullscreen"
            },

            fullname() {
                return this.artwork.artist.firstname + " " + this.artwork.artist.lastname
            },
            available() {
                if (this.artwork.available) {
                    return "Beschikbaar"
                }

                return "Niet beschikbaar"
            },
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            }
        },
        mounted() {
            console.log('mounted')
            this.fullscreen = false
            Artwork.dispatch('fetchArtwork', this.artwork_id).then(response => {
                Artwork.insertOrUpdate({data: response.data.data})
            })
        },
        components: {
            reservationButton
        }
    }
</script>

<style scoped>

</style>
