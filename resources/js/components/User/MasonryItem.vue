<template>
    <div class="masonry-item">
        <v-card >
            <img
                    :src="object.thumbnailurl"
                    :alt="object.name"
                    v-on:click="$emit('showDetail',object)"
                    class="masonry-content"

            />
            <v-card-text>

                <div>{{object.name}}</div>

                <div>
                    <span class="grey--text"
                          v-on:click="showDetails(object.artist)">{{object.artist.firstname}} {{object.artist.lastname}}</span><br>
                    <span v-if="!object.available "
                          v-bind:class="[object.available ? 'green--text' : 'red--text', 'help flex-end']"> {{availableString}}</span>
                </div>
            </v-card-text>
            <v-card-actions>
                <reservation-button :artwork_id="object.id" v-if="object.available"></reservation-button>
            </v-card-actions>
        </v-card>
    </div>

</template>

<script>
    import Reservation from '../../store/orm/Reservation'
    import reservationButton from './ReservationButton'
    import {EventBus} from "../../Event";

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
            },
            loggedIn() {
                return this.$store.getters['entities/users/isLoggedIn']
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

                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: this.object.name + "Gereserveerd",
                            type: "success"
                        })
                        this.loading = false;
                        console.log(response)
                    })
                    .catch(error => {
                        this.loading = false
                        if (error.response.status == 403) {
                            EventBus.$emit('message',
                                {
                                    component: 'notificationSnackbar',
                                    message: this.object.name + ' niet gereserveerd. Log in om te reserveren',
                                    type: 'error'
                                })

                            return
                        }
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: this.object.name + ' niet gereserveerd: ' + error.response.data.message,
                            type: 'error'
                        })

                        //TODO: load artwork
                    });
            },
            showDetails(item) {
                this.$router.push({name: 'userArtistDetail', params: {id: item.id}});
            }
        },
        components:{
            reservationButton
        }
    }
</script>

<style scoped>
    img{
        width:100%;
    }

    .masonry-item {
        display: inline-block;
        vertical-align: top;
        margin-bottom: 10px;
        width:100%;
    }

    .masonry-item, .masonry-content {
        border-radius: 4px;
        overflow: hidden;
    }
    .masonry-item {
        filter: drop-shadow(0px 2px 2px rgba(0, 0, 0, .3));
        transition: filter .25s ease-in-out;
        width:100%;

    }
    .masonry-item:hover {
        filter: drop-shadow(0px 5px 5px rgba(0, 0, 0, .3));
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
        height: auto;
        transform: scale(1.05);
        transition: transform 0.5s, opacity 0.5s;
        opacity: 0.7;

    }

    .masonry__container--image img:hover {
        opacity: 1;
        transform: scale(1.03);
    }

    /*  .masonry__container--image {
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
      !*! / column-gap: 1.5 em;*!
          column-gap: 1em;
          column-count: 3;
      }

      .masonry-card {
      !*! / display: inline-block;*!
      }

      .masonry__item {
          box-sizing: border-box;
          background-color: #eee;
          display: inline-block;
          margin: 0 0 1em;
          width: 100%;
      }

      .masonry__item:hover {
       !*box-shadow: 0 5 px 10 px rgba(0, 0, 0, .2);*!
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
          position: absolute; !* Position the background text *!
          bottom: 0; !* At the bottom. Use top:0 to append it to the top *!
          background: rgba(0, 0, 0, 0.5); !* Black background with 0.5 opacity *!
          color: #f1f1f1; !* Grey text *!
          width: 100%; !* Full width *!
          padding: 20px; !* Some padding *!
      }*/
</style>
