<template>
    <v-dialog
            v-model="dialog"
            max-width="500px"
            transition="dialog-bottom-transition"
            >
        <v-card>
            <v-card-text>
                <v-card-title><slot name="text"></slot></v-card-title>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        text
                        @click.native="$emit('confirm')"
                        :loading="confirming"
                        :disabled="confirming"
                >Bevestigen
                </v-btn>
                <v-btn
                        text
                        @click.native="$emit('cancel')"
                         :disabled="confirming"
                >Annuleren
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
        },
        methods:{
            cancel(){
                console.log('cancel')
            }
        },
        watch:{
            dialog(){
                if(!this.dialog){
                    this.$emit('cancel')
                }
            }
        }
    }
</script>

<style scoped>

</style>
