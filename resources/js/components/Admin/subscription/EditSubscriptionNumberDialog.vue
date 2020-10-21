<template>
    <v-dialog v-model="dialog" width="500">
        <v-card>
            <v-card-title>
                <span class="title">Lidkaartnummer wijzigen</span>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-text-field
                            v-model="number"
                            label="Lidkaardnummer"
                            type="number"
                    />
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn :loading="updating" flat v-on:click="updateNumber">Nummer wijzigen</v-btn>

                <v-btn :disabled="updating" flat v-on:click="close">Annuleren</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Subscription from "../../../store/orm/Subscription";
    import {EventBus} from "../../../Event";

    export default {
        name: "EditSubscriptionNumberDialog",
        props: {
            subscription: {
                required: true
            },
            dialog: {
                required: true
            }
        },
        data() {
            return {
                number: this.subscription.number,
                updating: false
            }
        },
        watch: {
            dialog() {
                if (this.dialog) {
                    this.number = this.subscription.number
                }
            }
        },
        methods: {
            updateNumber() {
                this.updating = true
                axios.put('api/subscriptions/' + this.subscription.id, {
                    number: this.number
                }).then(response => {
                    this.updating = false
                    Subscription.insertOrUpdate({data: response.data.data})
                    this.close()
                }).catch(error => {
                    EventBus.$emit('message',
                        {
                            component: 'notificationSnackbar',
                            message: 'Fout bij wijzigen Lidkaartnummer',
                            type: 'error'
                        })
                    this.updating = false
                })

            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>

<style scoped>

</style>
