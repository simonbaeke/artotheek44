<template>
    <div class="">

        <v-data-iterator
                :items="artworks"
                :items-per-page.sync="rowsPerPageItems" >

            <template v-slot:default="props">
                <div class="masonry">


                <masonry-item

                        v-for="item in props.items"
                        :key="item.id"

                        :object="item"
                        v-on:showDetail="showDetail(item)"
                ></masonry-item>
                </div>
            </template>


        </v-data-iterator>

        <app-alert></app-alert>

        <artwork-detail v-if="selectedObject"
                        :artwork_id="selectedObject"
                        :showDetail="showFullscreen"
                        v-on:close="closeFullscreen">
            <template slot="title">
                {{selectedObject.name}}
            </template>
        </artwork-detail>
    </div>
</template>

<script>
    import artworkDetail from './ArtworkDetail.vue'
    import masonryItem from './MasonryItem.vue'
    import appAlert from '../Alert.vue'
    import {EventBus} from "../../Event";

    export default {
        name: "Masonry",
        props: ['artworks'],
        data() {
            return {
                available: false,
                searchString: "",
                filter: [],
                fullscreenUrl: "",
                showFullscreen: false,
                selectedObject: null,
                rowsPerPageItems: 20,

            }
        },
        methods: {
            showDetail(object) {
                this.selectedObject = object.id
                this.showFullscreen = true
            },
            closeFullscreen() {
                this.selectedObject = null
                this.showFullscreen = false
            }
        },

        components: {
            artworkDetail,
            masonryItem,
            appAlert
        },
        created: function () {
            EventBus.$on('showDetail', data => {
                this.selectedObject = object.id
                this.showFullscreen = true
            })
        }
    }
</script>

<style>

    .v-data-iterator > div:first-child {
        column-count: 3;
    }

    .masonry-wrapper {
        padding: 1.5em;
        max-width: 960px;
        margin-right: auto;
        margin-left: auto;
    }

    .masonry {
        columns: 3;
        column-gap: 10px;
        width: 100%;
    }

    .masonry-item {
        display: inline-block;
        vertical-align: top;
        margin-bottom: 10px;
        width: 100%;

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

    /*    .masonry__container--image {
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

        .v-data-iterator>div:first-child {
            margin: 0rem auto;
            padding: 1rem 2rem;
            width: 100%;
          !*column-gap: 1.5 em;*!
            column-gap: 1em;
            column-count: 4;

        }

        @media (max-width: 56.25em) {
            .v-data-iterator>div:first-child {
                column-count: 1;
                padding: 1rem 0rem;

            }

        }

        .masonry-card {
         !*display: inline-block;*!
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
