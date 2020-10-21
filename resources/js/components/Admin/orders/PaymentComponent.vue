<template>
    <v-container>
        <div class="title mb-1" v-if="payments.length==1">Geselecteerde betaling</div>
        <div class="title mb-1" v-if="payments.length>1">Geselecteerde betalingen</div>

        <div v-for="(payment,index) in payments" :key="payment.id">
                <pay-line-component :id="payment.id"></pay-line-component>
        </div>
    </v-container>
</template>

<script>
    import Invoice from "../../../store/orm/Invoice";
    import Pay from "../../../store/orm/Pay";
    import payLineComponent from './PayLineComponent'

    export default {
        name: "PaymentComponent",
        props: {
            invoiceId: {
                required: true
            }
        },
        data() {
            return {
                deleting: false
            }
        },
        computed: {
            invoice() {
                return Invoice.find(this.invoiceId)
            },
            payments() {
                return Pay.query().where('invoice_id', this.invoiceId).get()
            }

        },
        components: {
            payLineComponent
        },
        mounted() {

            //geeft foutmelding
/*            if (!Invoice.find(this.invoicdeId)) {
                axios.get('api/invoices/' + this.invoiceId).then(response => {
                    Invoice.insertOrUpdate({data: response.data.data})
                })
            }*/


        }
    }
</script>

<style scoped>

</style>
