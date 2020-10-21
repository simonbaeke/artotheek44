<template>
    <v-dialog v-model="dialog.dialog" max-width="500px">
        <v-card>
            <v-card-text>
                <span>Reservering stoppen?</span>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        flat
                        @click.native="stopRent"
                        :loading="stopping"
                        :disabled="stopping"
                >Ja graag
                </v-btn>
                <v-btn
                        flat
                        @click.native="dialog.close()"
                        :disabled="stopping"
                >Nee, foutje...
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Reservation from '../../../store/orm/Reservation'

    export default {
        name: "StopReservationButton",
        props: {
            dialog: {type: Object, required: true}
        },
        data() {
            return {
                stopping: false
            }

        },
        computed: {
            reservation() {
                return Reservation.find(this.dialog.form.reservation)
            }
        },
        methods: {
            stopReservation() {
                this.stopping = true;

                this.$store.dispatch('stopReservation', this.reservation
                ).then(response => {
                    this.stopping = false
                    this.dialog.close()
                }).catch(error => {
                    this.stopping = false;
                    this.dialog.close()
                })
            },
        }

    }
</script>

<style scoped>

</style>
