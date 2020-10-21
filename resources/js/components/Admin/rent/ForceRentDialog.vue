<template>
    <v-row justify="center">
        <v-dialog
                v-model="dialog"
                persistant
                max-width="400"
        >
            <v-card>
                <v-card-title class="headline">Kunstwerk is niet beschikbaar</v-card-title>

                <v-card-text>
                    <div
                            v-if="loading"
                    >
                        <v-progress-circular
                                :size="50"
                                color="primary"
                                indeterminate
                        ></v-progress-circular>
                    </div>
                    <div v-if="!loading">
                        <div v-if="rents.length>0">
                            <p>Kunstwerk {{artwork.name}} is ontleend door {{rents[0].user.fullname}}</p>
                            <p>Klik OK indien het kunstwerk toch beschikbaar is in de artotheek en probeer opnieuw

                            </p>
                        </div>
                        <div v-if="reservations.length>0"></div>
                    </div>

                </v-card-text>

                <v-card-actions>

                    <v-btn
                            text
                            @click="close"
                    >
                        Annuleer
                    </v-btn>

                    <v-btn
                            text
                            @click="save"
                    >
                        OK
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>

</template>

<script>
    import Artwork from "../../../store/orm/Artwork";
    import Rent from "../../../store/orm/Rent";
    import Reservation from "../../../store/orm/Reservation";

    export default {
        name: "ForceRentDialog",
        props: {
            dialog: {
                required: true
            },
            code: {required: true}
        },
        data() {
            return {
                rents: [],
                reservations: [],
                loading: false,
                artwork: {
                    name: ""
                }
            }
        },
        methods: {
            close() {
                this.$emit('close')
                this.rents = []
                this.reservations = []
                this.artwork.name = ""
            },
            save() {
                this.$store.dispatch('updateRent', {
                    returned: true,
                    id: this.rents[0].id,
                }).then(e => {
                    this.close()
                })
            }
        },
        watch: {
            dialog() {
                if (this.dialog) {
                    this.artwork = Artwork.query().where('code', this.code).first()

                    this.loading = true
                    let rent = Rent.dispatch('fetch', {'returned': false, 'artwork': this.artwork.id})
                    let reservation = Reservation.dispatch('fetch', {active: true, artwork: this.artwork.id})

                    Promise.all([rent, reservation]).then(result => {
                        this.rents = result[0].data.data
                        this.reservation = result[1].data.data

                    }).finally(
                        e =>
                            this.loading = false
                    )
                }
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>

</style>
