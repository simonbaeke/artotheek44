<template>
    <div>
        <v-btn outlined v-on:click="$emit('edit')">Wijzig ontlening</v-btn>
        <v-btn outlined :loading="renewing" v-on:click="renewDialog=true">Verlengen</v-btn>
        <v-btn outlined :loading="stopping" v-on:click="stopDialog=true">Stoppen</v-btn>


        <confirm-dialog
                :dialog="stopDialog"
                :confirming="stopping"
                v-on:confirm="stop"
                v-on:cancel="stopDialog=false"
        >
            <template slot="text">Ontlening stoppen?</template>

        </confirm-dialog>
        <confirm-dialog :dialog="renewDialog"
                        :confirming="renewing"
                        v-on:confirm="renew"
                        v-on:cancel="renewDialog=false">
            <template slot="text">Ontlening verlengen</template>
        </confirm-dialog>
    </div>
</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import Artwork from '../../../store/orm/Artwork'
    import Expire from "../../../store/orm/Expire";
    import confirmDialog from '../dialog/ConfirmDialog'
    import Subscription from "../../../store/orm/Subscription";

    export default {
        name: "EditRentDialog",
        props: {
            rent: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                stopDialog: false,
                stopping: false,
                renewDialog: false,
                renewing: false
            }
        },
        computed: {
            artwork() {
                if (this.rent != null) {

                    return Artwork.find(this.rent.artwork_id)
                }
                return null
            },
            expire() {
                return Expire.query()
                    .where('expirable_type', 'Rent')
                    .where('expirable_id', this.rent.id)
                    .first().date
            }
        },
        methods: {
            stop() {
                this.stopping = true;

                this.$store.dispatch('updateRent', {
                    returned: true,
                    id: this.rent.id,
                }).then(response => {
                    Subscription.dispatch('fetchSubscriptionById', this.rent.subscription_id).then(() => {

                        this.stopping = false
                        this.stopRentDialog = false
                    }).catch(() => {
                        this.stopping = false
                        this.stopRentDialog = false
                    })

                }).catch(error => {
                    this.stopping = false;
                    this.stopRentDialog = false
                })
            },
            renew() {
                this.renewing = true

                Expire.dispatch('create', {
                    expirable_id: this.rent.id,
                    expirable_type: 'Rent',
                    user_id: Subscription.find(this.rent.subscription_id).user_id,
                }).then(() => {
                    this.renewDialog = false
                    this.renewing = false
                }).catch(() => {
                    this.renewDialog = false
                    this.renewing = false
                })
            }
        },
        components: {
            confirmDialog
        }
    }
</script>

<style scoped>

</style>
