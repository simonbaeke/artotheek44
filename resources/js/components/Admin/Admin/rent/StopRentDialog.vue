<template>
    <v-dialog v-model="dialog" max-width="500px" transition="dialog-bottom-transition">
        <v-card>
            <v-card-text>
                <span>Ontlening stoppen?</span>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        flat
                        @click.native="stop"
                        :loading="stopping"
                        :disabled="stopping"
                >Ja graag
                </v-btn>
                <v-btn
                        flat
                        @click.native="close"
                        :disabled="stopping"
                >Nee, foutje...
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import {EventBus} from "@/Event";

    export default {
        name: "StopRentDialog",
        data() {
            return {
                stopping: false,
                dialog: false,
                rentId: ""
            }
        },
        computed: {
            rent() {
                return Rent.find(this.rentId)
            }
        },
        methods: {
            stop() {
                this.stopping = true;

                this.$store.dispatch('updateRent', {
                    returned: true,
                    expires: this.rent.expires,
                    id: this.rent.id,
                }).then(response => {
                    this.stopping = false
                    this.dialog = false
                }).catch(error => {
                    this.stopping = false;
                    this.dialog = false
                })
            },
            close() {
                this.dialog = false
            }
        },
        created() {
            EventBus.$on('stoprent', (rent) => {
                this.dialog = true;
                this.rentId = rent
            })
        }

    }
</script>

<style scoped>

</style>
