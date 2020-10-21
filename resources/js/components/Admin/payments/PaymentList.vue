<template>
    <app-main>

        <template slot="title">
            Betalingen
        </template>

        <template slot="content">
            <app-content>
                <template slot="toolbar">
                    <v-flex md6>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Zoek naar een betaling"
                                single-line
                                hide-details
                        ></v-text-field>
                    </v-flex>
                    <v-spacer/>
                    <confirm-bank-transfert-dialog></confirm-bank-transfert-dialog>
                </template>
                <template slot="text">
                    <v-data-table
                            :headers="headers"
                            :items="payments"
                            :loading="loading"
                            :search="search"
                            no-results-text="Geen betalingen gevonden"
                            no-data-text=""
                    >
                        <template v-slot:body="{ items }">
                            <tbody>
                            <tr v-for="(item,index) in items" :key="item.id">
                                <td>{{item.id}}</td>
                                <td>{{item.user}}</td>
                                <td>{{item.date}}</td>
                                <td @click="showStatement(item.type == 'BankTransfert',item.payable)">{{item.type}}</td>
                                <td>{{item.status}}</td>
                                <td>{{item.amount}}</td>
                                <v-dialog></v-dialog>
                            </tr>
                            <v-dialog
                                    v-model="dialog"
                                    width="500"
                            >


                                <v-card>
                                    <v-card-title
                                            class="headline grey lighten-2"
                                            primary-title
                                    >
                                        Mededeling
                                    </v-card-title>

                                    <v-card-text>
                                        {{statement}}
                                    </v-card-text>

                                    <v-divider></v-divider>

                                    <v-card-actions>
                                        <div class="flex-grow-1"></div>
                                        <v-btn
                                                color="primary"
                                                text
                                                @click="dialog = false"
                                        >
                                            Sluit
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            </tbody>
                        </template>
                    </v-data-table>

                </template>
            </app-content>
        </template>
    </app-main>
</template>

<script>
    import Pay from "../../../store/orm/Pay";
    import BankTransfert from "../../../store/orm/BankTransfert"
    import Cash from "../../../store/orm/Cash";
    import confirmBankTransfertComponent from './ConfirmBankTransfertComponent'
    import paymentExpand from './PaymentExpand'
    import confirmBankTransfertDialog from './ConfirmBankTransfertDialog'
    import appMain from '../basis/main'
    import appContent from '../basis/content'

    export default {
        name: "PaymentList",
        data() {
            return {
                dialog: false,
                search: "",
                loading: false,
                headers: [
                    {
                        text: 'Id',
                        align: 'left',
                        sortable: true,
                        value: 'id'
                    },
                    {text: 'Gebruiker', sortable: false, value: 'user'},
                    {text: 'Datum', sortable: false, value: 'date'},
                    {text: 'Type', sortable: false, value: 'type'},
                    {text: 'Status', sortable: true, value: 'status'},
                    {text: 'Bedrag', sortable: false, value: 'amount'},

                ],
                rowsPerPage: [10],
                statement: ''
                //rowsPerPage: [10, 25, { "text": "$vuetify.dataIterator.rowsPerPageAll", "value": -1 } ]
            }
        },
        computed: {
            payments() {
                if (this.loading) {
                    return []
                }
                let vm = this

                return Pay.query()
                    .where('payable_type', 'BankTransfert')
                    .orWhere('payable_type', 'Cash')
                    .whereHas('invoice', query => {
                        query.where('confirmed', true)
                    })
                    .with('invoice.user')
                    .get().map(pay => {
                        let p = this.$store.getters['entities/' + this.lowerFirstLetter(pay.payable_type) + 's/find'](pay.payable_id)

                        if (!p) {
                            return [
                                {
                                    id: pay.id,
                                    user: pay.invoice.user.firstname + ' ' + pay.invoice.user.lastname,
                                    type: pay.payable_type,
                                    status: 'not found',
                                    amount: 'no idea',
                                    invoice: pay.invoice,
                                    payable: p
                                }
                            ]
                        }
                        return {

                            id: pay.id,
                            user: pay.invoice.user.firstname + ' ' + pay.invoice.user.lastname,
                            type: pay.payable_type,
                            status: p.confirmed ? 'OK' : 'Open',
                            amount: p.amount,
                            invoice: pay.invoice,
                            payable: p,
                            date: p.date
                        }

                    })
            }
        },
        methods: {
            fetchPays() {
                this.loading = true
                Pay.deleteAll()
                BankTransfert.deleteAll()
                Cash.deleteAll()
                let promis1 = axios.get('api/banktransferts').then(response => {
                    BankTransfert.insertOrUpdate({data: response.data.data})
                })

                let promise2 = axios.get('api/cashs').then(response => {
                    Cash.insertOrUpdate({data: response.data.data})
                })

                Promise.all([promis1, promise2]).then(() => {
                    this.loading = false
                })
            },

            lowerFirstLetter(string) {
                return string.charAt(0).toLowerCase() + string.slice(1);
            },

            showStatement(isBankTransfert, payable) {
                if (isBankTransfert) {
                    this.dialog = true
                    this.statement = payable.statement
                }
            }
        },
        mounted() {
            this.fetchPays()
        },
        components: {
            confirmBankTransfertComponent,
            paymentExpand,
            confirmBankTransfertDialog,
            appMain,
            appContent
        }
    }
</script>

<style scoped>

</style>
