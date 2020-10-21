<template>
    <v-hover>
        <v-card
                slot-scope="{ hover }"
                class="mx-auto"
                color="grey lighten-4"
                max-width="600"
        >
            <v-img
                    :src="object.thumbnailurl"
            >
                <v-expand-transition>
                    <div
                            v-if="hover && object.available"
                            class="d-flex transition-fast-in-fast-out success darken-2 v-card--reveal display-2 white--text"
                            style="height: 100%;"
                    >
                        {{availableString}}
                    </div>

                    <div
                            v-if="hover && !object.available"
                            class="d-flex transition-fast-in-fast-out error darken-2 v-card--reveal display-1 white--text"
                            style="height: 100%;"
                    >
                        {{availableString}}
                    </div>
                </v-expand-transition>
            </v-img>
            <v-card-text
                    class="pt-4"
                    style="position: relative;"
            >
                <v-btn
                        v-if="object.available"
                        absolute
                        color="primary"
                        class="white--text"
                        fab
                        small
                        right
                        top
                >
                    <v-icon>close</v-icon>
                </v-btn>
                <div class=" ">{{object.name}}</div>
                <div class="font-weight-light grey--text ">{{object.artist.firstname}}</div>
                <div class="font-weight-light grey--text grey--text" v-if="hasLastName">{{object.artist.lastname}}</div>

            </v-card-text>
        </v-card>
    </v-hover>



</template>

<script>
    import Reservation from '../../store/orm/Reservation'

    export default {
        name: "MasonryItem",
        props: ['object'],
        data() {
            return {
                loading: false
            }
        },
        computed: {
            hasLastName() {
                return this.object.artist.lastname.length > 0;
            },
            availableString() {
                if (this.object.available) {
                    return "Beschikbaar"
                }
                return "Niet beschikbaar";
            }
        },
        methods: {
            fullscreen(index) {
                // this.showFullscreen = true;
                // this.fullscreenUrl = this.objects[index].thumbnailurl
                // this.selectedObject = this.objects[index]
            },

            makeReservation(artwork_id) {
                this.loading = true;
                Reservation.dispatch('makeReservation', artwork_id)
                    .then(response => {
                        this.$store.commit('setSuccess', 'reservering aangemaakt')
                        this.loading = false;
                        console.log(response)
                    })
                    .catch(error => {
                        this.loading = false
                        if (error.response.status == 403) {
                            this.$store.commit('setError', 'reservering niet aangemaakt: log in om te reserveren')
                            return
                        }
                        this.$store.commit('setError', 'reservering niet aangemaakt: ' + error.response.data.message)

                        //TODO: load artwork
                    });
            },
            showDetails(item) {
                this.$router.push({name: 'userArtistDetail', params: {id: item.id}});
            }
        }
    }
</script>

<style scoped>
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .5;
        position: absolute;
        width: 100%;
    }

    .masonry__container--image {
        margin-left: 0rem;
        margin-right: 0rem;
        margin-bottom: 0rem;
    }

    .content figure:not(:last-child) {
        margin-bottom: 0rem;
    }

    .modal {
        z-index: 100;
    }

    .masonry {
        margin: 8rem auto;
        padding: 1rem 2rem;
        width: 100%;
    / / column-gap: 1.5 em;
        column-gap: 1em;
        column-count: 3;
    }

    .masonry-card {
    / / display: inline-block;
    }

    .masonry__item {
        box-sizing: border-box;
        background-color: #eee;
        display: inline-block;
        margin: 0 0 1em;
        width: 100%;
    }

    .masonry__item:hover {
    / / box-shadow: 0 5 px 10 px rgba(0, 0, 0, .2);
    }

    .masonry__container {
        position: relative;
    }

    .masonry__container--image {
        margin-left: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 0;

        overflow: hidden;
        background-color: #000;
    }

    .masonry__container--image img {
        width: 100%;
        height: auto;
        transform: scale(1.05);
        transition: transform 0.5s, opacity 0.5s;
        opacity: 0.7;
    }

    .masonry__container--image img:hover {
        opacity: 1;
        transform: scale(1.03);
    }

    masonry__container--imagetext {
        position: absolute; /* Position the background text */
        bottom: 0; /* At the bottom. Use top:0 to append it to the top */
        background: rgba(0, 0, 0, 0.5); /* Black background with 0.5 opacity */
        color: #f1f1f1; /* Grey text */
        width: 100%; /* Full width */
        padding: 20px; /* Some padding */
    }
</style>
