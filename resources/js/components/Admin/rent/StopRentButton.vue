<template>
    <v-tooltip bottom>
        <v-dialog slot="activator" v-model="dialog" max-width="500px">
            <v-btn
                    slot="activator"
                    icon>
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
                            @click.native="$emit('stop')"
                            :loading="stopping"
                            :disabled="stopping"
                    >Ja graag
                    </v-btn>
                    <v-btn
                            flat
                            @click.native="dialog=false"
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
            stopping: {
                type: Boolean,
                required: true
            },
            rent: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                dialog: false
            }
        },
        watch: {
            stopping() {
                if (!this.stopping) {
                    this.dialog = false
                }
            }
        }
    }
</script>

<style scoped>

</style>
