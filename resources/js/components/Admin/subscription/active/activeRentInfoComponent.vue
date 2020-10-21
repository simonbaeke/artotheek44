<template>
    <div>
        <span class="headline">Lopende ontlening</span>

        <v-simple-table>
            <template v-slot:default>
                <thead>
                <tr>
                    <th class="text-left">Kunstwerk</th>
                    <th class="text-left">Code</th>
                    <th class="text-left">Ontleend op</th>
                    <th class="text-left">Terugbrengen op</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{rent.artwork.name}}</td>
                    <td>{{rent.artwork.code}}</td>
                    <td>{{ rent.started_at }}</td>
                    <td>{{ rent.expires_at}}</td>
                    <td class="text-right">
                        <v-btn outlined :loading="renewing" v-on:click="renewDialog=true">Verlengen</v-btn>
                        <v-btn outlined :loading="stopping" v-on:click="stopDialog=true">Stoppen</v-btn>
                        <v-btn outlined v-on:click="$emit('edit')">Wijzig ontlening</v-btn>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>

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
    import editRentDialog from '../../rent/EditRentDialog'
    import confirmDialog from '../../dialog/ConfirmDialog'
    import Artwork from '../../../../store/orm/Artwork'

    export default {
        name: "activeRentInfoComponent",
        props: {
            rent: {
                required: true
            }
        },
        data() {
            return {
                stopDialog:false,
                stopping:false,
                renewDialog:false,
                renewing:false
            }
        },
        computed: {
            artwork() {
                if (this.rent != null) {

                    return Artwork.find(this.rent.artwork_id)
                }
                return null
            }
        },
        methods: {
            stop() {
                this.stopping = true;

                this.$store.dispatch('stopRent', {
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
            editRentDialog,
            confirmDialog
        }
    }
</script>

<style scoped>

</style>
