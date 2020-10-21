<template>
    <div v-if="id!=null">
        <div class="hidden-print-only">
            <v-dialog v-model="dialog" persist max-width="500" hide-overlay light v-if="dialog">
                <v-card class="elevation-0 hidden-print-only">
                    <v-card-title>
                        <span class="title">Samenvatting</span>
                    </v-card-title>
                    <ul>
                        <li v-for="(order,index) in invoice.orders" :key="order.id">
                            {{order.model}} {{order.action}} {{order.amount}}
                        </li>

                    </ul>

                    <v-container>
                        <v-layout v-for="(payment,index) in invoice.pays" :key="payment.id">
                            <component :is="payment.payable_type.toString().toLowerCase() + 'Summary'"
                                       :id="payment.payable_id"></component>

                        </v-layout>
                    </v-container>

                    <v-card-actions class="hidden-print-only">
                        <v-btn v-on:click="$emit('close')">Close</v-btn>
                        <v-btn v-on:click="print">Print</v-btn>
                        <v-btn>Mail</v-btn>
                    </v-card-actions>
                </v-card>

            </v-dialog>
        </div>
        <div class="hidden-screen-only">
            <v-card class="elevation-0">
                <v-card-title>
                    <span class="title">Samenvatting</span>
                </v-card-title>
                <ul>
                    <li v-for="(order,index) in invoice.orders" :key="order.id">
                        {{order.model}} {{order.action}} {{order.amount}}
                    </li>

                </ul>

                <ul>
                    <v-layout v-for="(payment,index) in invoice.pays" :key="payment.id">
                        <component :is="payment.payable_type.toString().toLowerCase() + 'Summary'"
                                   :id="payment.payable_id"></component>

                    </v-layout>
                </ul>
            </v-card>
        </div>


    </div>

</template>

<script>
    import banktransfertSummary from './BankTransfertSummary'
    import cashSummary from './CashSummary'
    import voucherpaySummary from './VoucherPaySummary'
    import Invoice from "@/store/orm/Invoice";

    export default {

        name: "OrderSummaryComponent",
        props: ['id', 'dialog'],
        data() {
            return {}
        },
        methods: {
            print() {

                const {Printd} = window.print()

                this.d = new Printd()


                this.d.print(this.$el, this.cssText)

            },
            lowerFirstLetter(string) {
                return string.charAt(0).toLowerCase() + string.slice(1);
            }
        },
        components: {
            banktransfertSummary,
            cashSummary,
            voucherpaySummary
        },
        computed: {
            invoice() {
                return Invoice.query()
                    .where('id', this.id)
                    .with('orders')
                    .with('pays')
                    .first()
            }
        }


    }
</script>

<style scoped>
    .hidden-screen-only {
        position: absolute;
        left: 0;
    }
</style>
