<template>
    <v-layout class="mx-5 mt-4 mb-3" style="border:1px solid #9E9E9E;padding:1rem;">
        <v-flex xs12 md4>
            <v-layout v-for="(order,index) in invoice.orders" :key="order.id" row class="grey--text">
                <v-flex xs6>
                    <component
                            :is="order.orderable_type.toLowerCase() + 'DetailComponent'"
                            :id="order.orderable_id"/>
                </v-flex>
                <v-flex xs2>
                    {{order.amount}}
                </v-flex>
            </v-layout>
        </v-flex>
        <v-divider vertical class="mr-5"></v-divider>

        <v-flex md6 v-for="(pay,index) in invoice.pays" :key="index">
            <compontent
                    :is="pay.payable_type.toLowerCase() + 'Component'"
                    :id="pay.payable_id"
                    statement
            />

        </v-flex>

    </v-layout>

</template>

<script>
    import Invoice from "@/store/orm/Invoice";
    import Order from "@/store/orm/Order";
    import subscriptionDetailComponent from '../orders/detail/SubscriptionComponent'
    import rentDetailComponent from '../orders/detail/RentComponent'
    import expireDetailComponent from '../orders/detail/ExpireComponent'
    import confirmedDetailComponent from '../orders/detail/ConfirmedComponent'
    import banktransfertComponent from './BankTransfertLine'
    import cashComponent from './CashLine'


    export default {
        name: "PaymentExpand",
        props: {
            invoiceId: {
                required: true
            },
            payable: {
                required: true
            }
        },
        computed: {
            invoice() {
                return Invoice.query().where('id', this.invoiceId).with('orders').with('pays').first()
            }
        },
        mounted() {
            //fetch orders
            axios.get('api/orders', {
                params: {
                    invoice: this.invoiceId
                }
            }).then(response => {
                Order.insertOrUpdate({data: response.data.data})
            })

            //fetch payments
        },
        components: {
            subscriptionDetailComponent,
            expireDetailComponent,
            rentDetailComponent,
            banktransfertComponent,
            cashComponent,
            confirmedDetailComponent
        }
    }
</script>

<style scoped>

</style>
