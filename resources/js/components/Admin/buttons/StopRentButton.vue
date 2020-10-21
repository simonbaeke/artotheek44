<template>
    <v-tooltip bottom>
        <v-dialog slot="activator" v-model="dialog" max-width="500px">
            <v-btn
                    slot="activator"
                    icon
            >
                <v-icon small>clear</v-icon>
            </v-btn>
            <v-card>
                <v-card-text>
                    <span>Ontlening stoppen?</span>
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
                            @click.native="close"
                            :disabled="stopping"
                    >Nee, foutje...
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <span>Stop ontlening</span>
    </v-tooltip>
</template>

<script>
    export default {
        name: "StopRentButton",
        props: {
            rent: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                dialog: false,
                stopping: false
            }
        },
        methods: {
            stopRent() {
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
        }
    }
</script>

<style scoped>

</style>
