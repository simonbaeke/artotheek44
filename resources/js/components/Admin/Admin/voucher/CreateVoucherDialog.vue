<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">Cadeaubon aanmaken</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-checkbox v-model="registered" label="Geregistreerde gebruiker"/>
                        </v-flex>
                        <v-flex xs12 sm12 md12 v-if="registered">
                            <v-autocomplete
                                    :items="users"
                                    item-text="firstname"
                                    item-value="id"
                                    label="Geschonken door"
                                    v-model="form.from_id"
                                    :error="form.hasError('from_id')"
                                    :error-messages="form.error('from_id','Gever')"
                            ></v-autocomplete>
                        </v-flex>

                        <v-flex xs12>
                            <v-text-field
                                    label="bedrag"
                                    type="number"
                                    min="0"
                                    step="5"
                                    required
                                    readonly
                                    v-model="form.amount"
                                    :error="form.hasError('amount')"
                                    :error-messages="form.error('amount','Bedrag')"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                                    label="Code"
                                    type="text"
                                    required
                                    :error="form.hasError('code')"
                                    :error-messages="form.error('code','Code')"
                                    v-model="form.code"></v-text-field>
                        </v-flex>
                        <v-flex>
                            <v-checkbox v-model="existing" label="Bestaande bon"/>
                        </v-flex>
                        <v-flex v-if="!existing">
                            <v-select
                                    :items="betaalopties"
                                    item-text="key"
                                    item-value="value"
                                    label="Selecteer een betaaloptie"
                                    v-model="selectedBetaaloptie"
                                    class="mt-4"
                            >
                            </v-select>                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn flat @click="close">Sluiten</v-btn>
                <v-btn flat v-on:click="save">Opslaan</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import Voucher from '../../../store/orm/Voucher'
    import User from '../../../store/orm/User'
    import {Form} from "@/Form";

    export default {
        name: "CreateVoucherDialog",
        props: ['dialog'],
        data() {
            return {
                form: new Form({
                    from_id: "",
                    amount: 25,
                    code: ""

                }),
                existing: true,
                registered:false,
                betaalopties:[
                    {key: 'Cash', value: 'cash'},
                ],
                selectedBetaaloptie:"cash"
            }
        },
        methods: {
            close() {
                //reset form
                this.form.reset()
                this.registerd = false
                this.existing =false
                this.form.amount = 25
                this.$emit('close')
            },
            save() {

                let voucherdata = {
                    amount: this.form.amount,
                    existing: this.existing,
                    registered: this.registered,
                    paymentoption:this.selectedBetaaloptie
                }

                if (this.form.from_id != ""){
                    voucherdata['from_id'] = this.form.from_id
                }

                let vm = this
                if (this.existing) {
                    voucherdata.code = this.form.code
                }


                Voucher.dispatch('store', voucherdata)
                    .then(response => {

                        this.close()
                        if (!vm.existing) {
                            this.$router.push({name: 'userdetail', params: {id: voucherdata.from_id}})
                        }

                    })
                    .catch(error => {

                        this.form.setErrors(JSON.parse(error.request.response).errors)
                    })
            }
        },
        computed: {
            users() {
                return User.all()
            }
        },
        watch: {
            registerd() {
                if (!this.registered) {
                    this.form.from_id = ""
                }
            }
        }
    }
</script>

<style scoped>

</style>
