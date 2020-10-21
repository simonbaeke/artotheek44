<template>
    <div>

        <v-card class="elevation-0 hidden-print-only">
            <v-card-title>

            </v-card-title>
            <v-card-text v-if="!invoice && !loading" >
                Niks te betalen
            </v-card-text>
            <v-card-text v-if="loading">
                orders ophalen
            </v-card-text>
            <v-card-text v-if="invoice">
                <v-data-table
                        :loading="loading"
                        :items=orders
                        :headers="orderHeaders"
                        hide-default-footer
                        no-data-text="Geen te verwerken orders"
                >

                    <template v-slot:item="{item}">
                        <tr>
                            <td>{{item.id}}</td>
                            <td >
                                <component
                                        :is="item.orderable_type.toLowerCase() + 'DetailComponent'"
                                        :id="item.orderable_id"/>
                            </td>
                            <td>
                                {{item.amount}}
                            </td>
                            <td>
                                <delete-order-button
                                        :id="item.id"
                                />
                            </td>
                        </tr>


                    </template>
                    <template slot="footer">
                        <td :colspan="orderHeaders.length-1" class="text-xs-right pr-5">
                            <strong>Totaal:</strong>
                            <span>{{totalAmount}}€</span>
                        </td>
                        <td colspan="1"></td>
                    </template>
                </v-data-table>

                <v-layout>
                    <v-flex xs12 md4>
                        <pay-component :invoiceId="invoiceId"></pay-component>
                    </v-flex>
                </v-layout>

            </v-card-text>

            <v-divider></v-divider>
            <v-card-actions v-if="invoice">
                <v-btn
                        text

                        v-on:click="showPayDialog=true"
                        v-if="totalAmount>payedAmount"
                >Selecteer Betaling
                </v-btn>
                <v-btn
                        text
                        v-if="totalAmount<=payedAmount "
                        v-on:click="confirmInvoice(invoiceId)"

                >Bevestig
                </v-btn>
                <v-btn
                        text>Verwijder
                </v-btn>

            </v-card-actions>
            <pay-dialog
                    :invoiceid="invoiceId"
                    :dialog="showPayDialog"
                    v-on:close="showPayDialog=false">
            </pay-dialog>
        </v-card>
        <order-summary
                :id="showSummary"
                :dialog="showSummary!=null"
                v-on:close="showSummary = null"/>
    </div>
</template>

<script>
    import Order from '../../../store/orm/Order'
    import Invoice from '../../../store/orm/Invoice'
    import Pay from '../../../store/orm/Pay'
    import Subscription from '../../../store/orm/Subscription'
    import payDialog from './PayDialog'
    import orderSummary from './OrderSummaryComponent'
    import subscriptionDetailComponent from './detail/SubscriptionComponent'
    import rentDetailComponent from './detail/RentComponent'
    import expireDetailComponent from './detail/ExpireComponent'
    import payComponent from './PaymentComponent'
    import confirmedDetailComponent from './detail/ConfirmedComponent'
    import voucherDetailComponent from './detail/VoucherComponent'
    import deleteOrderButton from './DeleteOrderButton'

    export default {
        name: "NewOrderComponent",
        props: {
            user: {
                required: true
            }
        },

        data() {
            return {
                loading: false,
                orderHeaders: [
                    {
                        text: 'Order ID',
                        align: 'left',
                        sortable: false
                    },
                    {text: 'Omschrijving', sortable: false},
                    {text: 'Prijs', sortable: false},
                    {text: 'Verwijder', sortable: false},
                ],
                showPayDialog: false,
                showSummary: null,
                lookup: [
                    {name: 'Cash', text: 'Cash'},
                    {name: 'VoucherPay', text: 'Cadeaubon'},
                    {name: 'BankTransfert', text: 'Overschrijving'}
                ],
            }
        },
        computed: {
            id() {
                return parseInt(this.$route.params.id)
            },

            invoice() {
                return Invoice.query().where('user_id', this.id)
                    .where('confirmed', false)
                    .withAll()
                    .first()
            },

            orders() {
                if (!this.invoice) {
                    return []
                }

                return Order.query().where('invoice_id', this.invoice.id).get()
            },
            totalAmount() {
                let total = 0;
                if (!this.invoice) {
                    return total
                }

                this.invoice.orders.forEach(order => {
                    total += order.amount
                })

                return total
            },
            payedAmount() {
                let total = 0;
                if (!this.invoice) {
                    return total
                }

                Pay.query().where('invoice_id', this.invoice.id).get().forEach(payment => {
                    total += payment.amount
                })

                return total
            },
            invoiceId() {
                if (!this.invoice) {
                    return null
                }

                return this.invoice.id
            }

        },
        methods: {

            paymentType(string) {
                return this.lookup.find(item => {
                    return item.name == string
                })
            },
            deleteOrder(id) {
                //delete subscriptions voor gebruiker
                /* Subscription.delete((record) => {
                     return record.user_id === this.user.id
                 })*/

                //delete order
                //delete orderable
                //delete invoice

                //insert invoice
                //TODO: bij deleten alle betalingen verwijderen

                let order = Order.find(id)

                //order verwijderen
                Order.dispatch('destroy', {id: id}).then(()=>{

                })

                /*                this.$store.dispatch('entities/' + order.orderable_type.toLowerCase() + 's/destroy', {
                                    id: order.orderable_id
                                }).then(() => {
                                    //Invoice.dispatch('show',{id:this.invoice.id})
                                    // .then
                                })*/

                //delete orderable
                /*                this.$store.dispatch('entities/delete', {
                                    entity: order.orderable_type.toLowerCase()+"s",
                                    where: order.orderable_id
                                })

                                Order.dispatch('destroy', {id: id}).then(response => {

                                    Subscription.dispatch('fetch', this.user.id)
                                })*/


            },
            confirmInvoice(invoiceid) {
                axios.put('api/invoices/' + invoiceid, {
                    'confirmed': true
                }).then(response => {
                    Invoice.insertOrUpdate({data: response.data.data})
                    //toon overzicht
                    this.showSummary = invoiceid;
                })
                    .catch(error => console.log(error))
            },

            fetchNewInvoice() {
                this.loading = true
                Invoice.dispatch('fetch', {
                    confirmed: false,
                    user: this.user.id
                }).then(() => {
                    this.loading = false
                }).catch(() => {
                    this.loading = false
                })
            }

        },
        components: {
            payDialog,
            orderSummary,
            subscriptionDetailComponent,
            expireDetailComponent,
            rentDetailComponent,
            payComponent,
            confirmedDetailComponent,
            voucherDetailComponent,
            deleteOrderButton
        },
        mounted() {
            this.fetchNewInvoice()
        }
    }
</script>

<style scoped>
    .verysmall {
        height: 1rem;
        width: 1rem;
    }
</style>
