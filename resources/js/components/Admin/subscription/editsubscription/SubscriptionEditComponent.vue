<template>
    <div>
        <v-simple-table
        >
            <template v-slot:default>
                <thead>
                <tr>
                    <th class="text-left">Lidkaartnummer</th>
                    <th class="text-left">Gestart op</th>
                    <th class="text-left">Verloopt op</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <v-text-field


                                v-model="editSubscription.number"
                        />
                    </td>
                    <td>
                        <v-menu
                                ref="started_at_menu"
                                v-model="started_atMenu"
                                :close-on-content-click="false"
                                :return-value.sync="editSubscription.started_at"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        v-model="editSubscription.started_at"

                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="editSubscription.started_at" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="started_atMenu = false">Cancel</v-btn>
                                <v-btn text color="primary"
                                       @click="$refs.started_at_menu.save(editSubscription.started_at)">OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </td>
                    <td>
                        <v-menu
                                ref="expire_at_menu"
                                v-model="expire_atMenu"
                                :close-on-content-click="false"
                                :return-value.sync="editExpire.date"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                        v-model="editExpire.date"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker v-model="editExpire.date" no-title scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="expire_atMenu = false">Cancel</v-btn>
                                <v-btn text color="primary" @click="$refs.expire_at_menu.save(editExpire.date)">OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </td>

                    <td class="text-right">
                        <v-btn
                                :loading="editing"
                                outlined @click="save">Opslaan
                        </v-btn>
                        <v-btn
                                :disabled="editing"
                                @click="$emit('cancel')"
                                outlined>Annuleren</v-btn>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-simple-table>

        <confirm-dialog
                :dialog="confirmDialog"
                :confirming="confirming"
                v-on:confirm="save"
                v-on:cancel="cancel"
        />
    </div>
</template>

<script>
    import confirmDialog from '../../dialog/ConfirmDialog'
    import Subscription from '../../../../store/orm/Subscription'
    import Expire from '../../../../store/orm/Expire'

    import {EventBus} from "../../../../Event";

    export default {
        name: "SubscriptionEditComponent",
        props: {
            subscription: {
                required: true,
                type: Object
            }
        },
        data() {
            return {
                confirmDialog: false,
                confirming: false,
                editSubscription: {
                    number: "",
                    started_at: ""
                },
                editExpire: {
                    date: ""
                },
                started_atMenu: false,
                expire_atMenu: false,
                editing: false
            }
        },
        methods: {
            save() {
                console.log('save')
                this.editing = true
                let s = this.updateSubscription()
                let t = this.updateExpire()

                Promise.all([s, t]).then(() => {
                    console.log('promise.all')
                }).then(() => {
                    this.editing = false
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Lidkaart gewijzigd',
                        type: 'success'
                    })
                    this.$emit('cancel')
                })

                this.confirmDialog = false
                this.confirming = false

            },
            updateSubscription() {

                return Subscription.dispatch('update', {
                    id: this.subscription.id,
                    params: {
                        'created_at': this.editSubscription.started_at,
                        'number': this.editSubscription.number,
                        '_method': 'PUT'
                    }
                })
            },
            updateExpire() {

                let expire  = Expire.query().where('expirable_type','Subscription','expirable_id',this.subscription.id).first()
                console.log('expire')
                return Expire.dispatch('update', {
                    id: expire.id,
                    params: {
                        'date': this.editExpire.date,
                        'updated_at': Date.parse(Date.now()),
                        '_method': 'PUT'
                    }
                })
            }

            ,
            cancel() {
                this.confirmDialog = false
                this.confirming = false
                this.$emit('cancel')
            }
        },
        mounted() {
            this.editSubscription.number = this.subscription.number
            this.editSubscription.started_at = this.subscription.started_at
            this.editExpire.date = this.subscription.expires_at
        },
        components: {
            confirmDialog
        }
    }
</script>

<style scoped>
    >>> .v-input__slot {
        margin-bottom: 0;
        border-radius: 4px !important;
        padding: 0 1.5rem !important;
    }
</style>
