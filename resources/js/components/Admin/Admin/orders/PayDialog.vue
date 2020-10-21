<template>
    <v-dialog v-model="dialog" max-width="500px" persistent>

        <v-card class="px-5 py-2">
            <v-card-text v-if="invoiceid != null">
                <h1>Selecteer betaalwijze</h1>
                <div v-for="(order,index) in invoice.orders">
                    <span class="grey--text">{{index + 1}}. {{order.model}} {{order.action}}  :{{order.amount}}€</span>
                </div>

                <v-form class="mt-4">
                    <span class="display-1 ">Totaal = {{invoice.total_amount}}€</span>
                    <v-select
                            outline
                            :items="betaalopties"
                            item-text="key"
                            item-value="value"
                            label="Selecteer een betaaloptie"
                            v-model="selectedBetaaloptie"
                            class="mt-4"
                    >
                    </v-select>
                    <select-voucher-component
                            v-on:valid="voucherid=$event"
                            v-on:amount="amount=$event"
                            v-on:invalid="resetVoucher"
                            v-on:reset="resetVoucher"
                            v-if="selectedBetaaloptie=='voucherPay'"
                            :visible="selectedBetaaloptie=='voucherPay'"
                    />


                    <v-text-field
                            label="Bedrag"
                            outline
                            v-model="amount"
                            readonly
                    ></v-text-field>
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                        flat
                        @click.native="createPay"
                        :loading="updating"
                        :disabled="selectedBetaaloptie=='' ||updating || (selectedBetaaloptie=='voucherPay' && voucherid==null)"
                >Toevoegen
                </v-btn>
                <v-btn
                        flat
                        @click.native="close"
                        :disabled="updating"
                >Annuleren
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<script>

    import Invoice from "@/store/orm/Invoice";
    import {EventBus} from "@/Event";
    import selectVoucherComponent from './SelectVoucherComponent'

    export default {
        name: "PayDialog",
        props: ['invoiceid', 'dialog'],
        data() {
            return {
                selectedBetaaloptie: "",
                referentie: "+++123/4567/89109+++",
                updating: false,
                amount: "",
                voucherid: null,
            }
        },
        watch: {
            selectedBetaaloptie() {
                if (this.selectedBetaaloptie != 'voucherPay') {
                    this.amount = this.invoice.total_amount - this.invoice.payed_amount
                } else {
                    this.amount = 0
                }
            }
        },
        methods: {


            createPay() {
                let formData = {
                    amount: this.amount,
                    invoice_id: this.invoiceid
                }

                if (this.selectedBetaaloptie == 'voucherPay') {
                    formData['voucher_id'] = this.voucherid
                } else {
                    user_id: this.invoice.user_id

                }
                let message = ""
                let type = "info"

                this.$store.dispatch('entities/' + this.selectedBetaaloptie + 's/store', formData)

                    .then((response) => {
                        message = "betaling toevoegd"
                        type = "success"
                    })
                    .catch(error => {

                            type = "error"
                            if (error.response.status == 400) {
                            } else {
                                message = "Server error"
                            }
                            //message = "Betaling niet aangemaakt: " + error.response.data.message

                            EventBus.$emit('message',
                                {
                                    component: 'notificationSnackbar',
                                    message: error,
                                    type: type
                                })
                        }
                    ).finally(() => {

                        this.close()

                    }
                )

            },
            close() {
                //reset everiting
                this.selectedBetaaloptie = ""
                this.updating = false
                this.amount = ""
                this.voucherid = null
                this.$emit('close')
            },
            resetVoucher() {
                this.voucherid = null
                this.amount = ""
            }
        }
        ,
        computed: {
            invoice() {
                if (!this.invoiceid) {
                    return null
                }
                return Invoice.query().where('id', this.invoiceid).with('orders').with('payments').first()
            },
            betaalopties(){
                if(this.invoice.total_amount>=25){
                    return                 [
                        {key: 'Cash', value: 'cash'},
                        {key: 'Overschrijving', value: 'bankTransfert'},
                        {key: 'Cadeaubon', value: 'voucherPay'}
                    ]
                }else{
                    return                 [
                        {key: 'Cash', value: 'cash'},
                        {key: 'Overschrijving', value: 'bankTransfert'},
                    ]
                }
            }
,



        },
        components: {
            selectVoucherComponent
        }
    }
</script>

<style scoped>

</style>
