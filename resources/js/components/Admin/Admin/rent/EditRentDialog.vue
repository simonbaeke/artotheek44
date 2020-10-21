<template>
    <v-flex xs12 md4>
        <span class="grey--text">Huur van het een kunstwerk</span>
        <v-layout>
            <v-btn-toggle>
                <v-btn color="white" :loading="renewing" v-on:click="renewDialog=true" >Verlengen</v-btn>
                <v-btn :loading="stopping"  v-on:click="stopDialog=true">Stoppen</v-btn>
            </v-btn-toggle>
        </v-layout>


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
    </v-flex>
</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import Artwork from '../../../store/orm/Artwork'
    import Expire from "@/store/orm/Expire";
    import confirmDialog from '../dialog/ConfirmDialog'
    import Subscription from "@/store/orm/Subscription";

    export default {
        name: "EditRentDialog",
        props: ['rent'],
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
                    this.stopping = false
                    this.stopRentDialog = false
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
