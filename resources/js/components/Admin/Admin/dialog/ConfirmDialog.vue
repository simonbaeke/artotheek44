<template>
    <v-dialog v-model="dialog" max-width="500px" transition="dialog-bottom-transition">
        <v-card>
            <v-card-text>
                <span><slot name="text"></slot></span>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        flat
                        @click.native="$emit('confirm')"
                        :loading="confirming"
                        :disabled="confirming"
                >Ja graag
                </v-btn>
                <v-btn
                        flat
                        @click.native="$emit('cancel')"
                        :disabled="confirming"
                >Nee, foutje...
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "ConfirmDialog",
        props: {
            confirming: {
                required: true,
                type: Boolean
            },
            dialog: {
                required: true,
                type: Boolean
            }
        }
    }
</script>

<style scoped>

</style>
