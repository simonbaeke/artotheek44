<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">{{newVoucher?'Nieuwe Cadeaubon aanmaken':'Bestaande cadeaubon ingeven'}}</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <!--<v-flex xs12>
                            <v-checkbox v-model="registered" label="Geregistreerde gebruiker"/>
                        </v-flex>-->
                        <v-flex xs12 sm12 md12 v-if="registered">
                            <v-autocomplete
                                    :items="users"
                                    item-text="search"
                                    item-value="id"
                                    label="Geschonken door"
                                    v-model="form.from_id"
                                    :error="form.hasError('from_id')"
                                    :error-messages="form.error('from_id','Gever')"
                            ></v-autocomplete>
                        </v-flex>
                        <v-flex xs12 sm12 md12 v-if="!registered">
                            <v-text-field
                                    label="koper"
                                    v-model="form.koper"
                                    :error="form.hasError('koper')"
                                    :error-messages="form.error('koper','koper')"
                            />
                        </v-flex>

                        <v-flex xs12>
                            <v-text-field
                                    label="bedrag"
                                    type="number"
                                    min="0"
                                    step="5"
                                    required
                                    v-model="form.amount"
                                    :error="form.hasError('amount')"
                                    :error-messages="form.error('amount','Bedrag')"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12 v-if="!newVoucher">
                            <v-text-field
                                    label="Code"
                                    type="text"
                                    required
                                    :error="form.hasError('code')"
                                    :error-messages="form.error('code','Code')"
                                    v-model="form.code"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn text @click="close">Sluiten</v-btn>
                <v-btn text v-on:click="save">Opslaan</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Voucher from '../../../store/orm/Voucher'
    import User from '../../../store/orm/User'
    import {Form} from "../../../Form";

    export default {
        name: "CreateVoucherDialog",
        props: {
            dialog: {
                required: true,
                type: Boolean
            },
            newVoucher: {
                required: true,
                type: Boolean
            }
        },
        data() {
            return {
                form: new Form({
                    from_id: "",
                    amount: 25,
                    code: "",
                    koper: ""

                }),
                existing: true,
                registered: true,
                betaalopties: [
                    {key: 'Cash', value: 'cash'},
                    {key: 'Overschrijving', value: 'bankTransfert'},
                ],
                selectedBetaaloptie: "cash"
            }
        },
        methods: {
            close() {
                //reset form
                this.form.reset()
                this.registerd = true
                this.existing = false
                this.form.amount = 25
                this.form.clearErrors()
                this.$emit('close')
            },
            save() {

                let voucherdata = {
                    amount: this.form.amount,
                    existing: !this.newVoucher,
                    registered: this.registered,
                }


                let vm = this
                if (this.existing) {
                    voucherdata.code = this.form.code
                } else {

                    voucherdata['paymentoption'] = this.selectedBetaaloptie

                }

                if (!this.registered) {
                    voucherdata['koper'] = this.form.koper
                } else {
                    voucherdata['from_id'] = this.form.from_id
                }


                Voucher.dispatch('store', voucherdata)
                    .then(response => {

                        this.close()
                        if (!vm.existing && vm.registered) {
                            this.$router.push({name: 'userdetail', params: {id: voucherdata.from_id}})
                        }
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Nieuwe bon aangemaakt',
                            type:'success'
                        })

                    })
                    .catch(error => {

                        this.form.setErrors(JSON.parse(error.request.response).errors)
                        EventBus.$emit('message', {
                            component: 'notificationSnackbar',
                            message: 'Bon niet aangemaakt',
                            type:'error'
                        })
                    })
            }
        },
        computed: {
            users() {
                return User.all().map(user => {
                    user.search = user.firstname + " " + user.lastname + " -- " + user.email
                    return user
                })
            }
        },
        watch: {
            registerd() {
                if (!this.registered) {
                    this.form.from_id = ""
                }
            }
        },
        mounted() {
            User.dispatch('fetch', {
                list: true
            })
        }
    }
</script>

<style scoped>

</style>
