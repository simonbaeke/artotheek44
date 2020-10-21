<template>
    <v-tabs
            color="#fafafa"
            fixed-tabs
    >
        <v-tab
                active-class="default-class is-active"
                v-bind:class="{'is-active': this.filter.length == 0}"
                v-on:click="filterObjects('all')"><a>Alles</a></v-tab>

        <v-tab
                active-class="default-class is-active"
                v-bind:class="{'is-active':filter.includes('painting')}"
                v-on:click="filterObjects('painting')"><a>Schilderij</a></v-tab>

        <v-tab
                active-class="default-class is-active"
                v-bind:class="{'is-active':filter.includes('sculpture')}"
                v-on:click="filterObjects('sculpture')"><a>Beeldhaudwerk</a></v-tab>
        <v-tab v-bind:class="{'is-active':available}"
               v-on:click="toggleAvailable"><a>Beschikbaar</a></v-tab>
    </v-tabs>
</template>

<script>

    export default {
        name: "Toolbar",
        data() {
            return {
                filter: [],
                available: false,
            }
        },

        methods: {
            toggleAvailable() {
                this.available = !this.available;
                eventBus.$emit('availableChanged', this.available);

            },

            filterObjects(filter) {

                if (filter == "all") {
                    this.filter = []
                } else {

                    if (this.filter.includes(filter)) {


                        var index = this.filter.indexOf(filter);
                        if (index > -1) {
                            this.filter.splice(index, 1);
                        }

                    }
                    else {
                        this.filter.push(filter)
                    }
                }

                //change filter


                eventBus.$emit('filterChanged', this.filter);

            }
        }
    }
</script>

<style scoped>
    .container {
        z-index: 100;
        width: 100VW !important;
        padding-right: 2rem;
        padding-left: 0.5rem;
    }

    .tabs {
        background: white;
        z-index: 10000;
        padding-bottom: 1rem;
    }
</style>
