<template>
    <div v-if="loaded" class="mdl-grid">
        <div class="mdl-cell mdl-cell--8-col mdl-cell--2-offset">
            <div class="demo-card-square mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-card--expand">
                    <h2 class="mdl-card__title-text">Nieuwe Ontlening</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <form action="#">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <label class="mdl-textfield__label" for="length">Duur (maand): </label>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <input class="mdl-textfield__input" type="number" id="length" min="1" max="12" step="1"
                                       name="length" v-model="months">
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <label class="mdl-textfield__label" for="expires">Ontlening tot: </label>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <input class="mdl-textfield__input" v-model="expires" type="date" id="expires"
                                       name="expires">
                                <span v-bind:class="[dateError ? 'error-visible' : '' , 'mdl-textfield__error']">Abonnement loop zo lang niet</span>

                            </div>
                        </div>
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--3-col mdl-grid--no-spacing">
                                <label class="mdl-textfield__label" for="object">Werk: </label>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col ">

                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="sample3" v-model="filter">
                                    <label class="mdl-textfield__label md-textfield-label-custom" for="sample3"><i
                                            class="material-icons">search</i></label>
                                </div>
                            </div>


                            <div class="mdl-cell mdl-cell--6-col mdl-grid--no-spacing">
                                <select class="mdl-textfield__input" v-model="selectedObject" type="date" id="object"
                                        name="object_id">
                                    <option v-for="(object, index) in filterObjects" v-bind:value="object.id">
                                        {{object.name}}
                                    </option>
                                </select>
                            </div>
                        </div>


                        <input type="hidden" id="subscription_id" name="subscription_id" v-model="subscriptionId">
                    </form>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <button class="mdl-button mdl-js-button mdl-button--raised" @click="onNewRent">
                        Bevestig
                    </button>
                    <button class="mdl-button mdl-js-button mdl-button--raised" @click="onCancel">
                        Annuleer
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Api} from "../../../Api";
    import {eventBus} from "../../app";

    export default {
        name: "RentCreate",
        data() {
            return {
                subscriptionId: this.$route.params.subscriptionId,
                subscription: [],
                objects: [],
                selectedObject: null,
                months: 6,
                api: new Api(),
                filter: "",
                dateError: false,

            }
        },
        computed: {
            expires() {
                var d = new Date();
                d.setMonth(d.getMonth() + parseInt(this.months));
                var subscriptionExpires = new Date(Date.parse(this.subscription.expires))
                //ook nog serverside chekcken
                if (subscriptionExpires > d) {
                    this.dateError = false;

                    return d.toISOString().slice(0, 10)
                }
                this.dateError = true;
                return subscriptionExpires.toISOString().slice(0, 10)

                return subscriptionExpires.format("yyyy-MM-dd")
            },

            filterObjects() {
                var i;
                var newArray = new Array()
                for (i = 0; i < this.objects.length; i++) {
                    if (this.objects[i].name.toUpperCase().indexOf(this.filter.toUpperCase()) > -1) {
                        newArray.push(this.objects[i]);
                    }
                }

                if (newArray.length > 0) {
                    this.selectedObject = newArray[0].id;
                }
                return newArray
            }
        },
        methods: {
            onNewRent() {
                axios.post('rents', {
                    expires: this.expires,
                    object_id: this.selectedObject,
                    subscription_id: this.subscription.id

                }).then(response => (
                    eventBus.$emit('snack', 'ontlening angemaakt'),
                        this.$router.go(-1)

                )).catch(error => (
                    eventBus.$emit('snack', 'Ontlening niet aangemaakt: ' + error.response.data.message),
                        console.log(error)
                ))
            },
            onCancel() {
                this.$router.go(-1);
            },
            fetchAvailableObjects() {
                this.api.getObjectlist().then(response => {
                    this.artworks = response.data;
                    this.selectedObject = this.artworks[0].id;
                }).catch(error => console.log(error));
            },

            fetchCreateRent() {
                axios
                    .get('/subscriptions/' + this.subscriptionId)
                    .then(response => (
                            this.subscription = response.data,
                                console.log(response.data),
                                this.loaded = true
                        )
                    )
                    .catch(error => console.log(error));
            }

        },

        mounted() {
            this.fetchAvailableartworks();
            this.fetchCreateRent();
            eventBus.$emit('searchBarDisabled', event);

            eventBus.$emit('setAction', {
                action: '',
                data: {},
                tooltip: ''
            });
        },
        beforeDestroy() {
            eventBus.$emit('searchBarEnabled', event);

        }

    }
</script>

<style scoped>
    .mdl-card {
        width: 100%;
    }

    .mdl-textfield__label {
        position: inherit;
    }

    .mdl-textfield__input {
        padding: 1px 0;
    }

    .md-textfield-label-custom {
        position: absolute;
        top: 1px;
    }

    .md-textfield-label-custom {
        padding: 1px 0;
    }

    .md-textfield-label-custom i {
        font-size: 1.2rem;
    }

    .mdl-textfield {
        padding: 1px 0;

    }

    .mdl-textfield--floating-label.is-focused .mdl-textfield__label {
        top: -18px;
    }

    .mdl-textfield--floating-label.is-dirty .mdl-textfield__label {
        top: -18px;
    }

    .mdl-textfield__label:after {
        background-color: transparent;
    }

    .error-visible {
        visibility: visible;
    }
</style>
