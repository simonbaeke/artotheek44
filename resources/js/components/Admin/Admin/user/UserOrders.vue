<template>
    <v-container>
        <v-tabs
                slot="extension"
                v-model="tab"
                grow
                dark
                class="hidden-print-only"
        >
            <v-tabs-slider></v-tabs-slider>

            <v-tab
                    v-for="item in items"
                    :key="item.name"
            >
                {{ item.name }}
            </v-tab>
        </v-tabs>
        <component
                :user="user"
                :is="items[tab].selectedComponent"/>
    </v-container>
</template>

<script>
    import Order from '../../../store/orm/Order'
    import Invoice from "@/store/orm/Invoice";
    import newOrderComponent from '../orders/NewOrderComponent'
    import openOrderComponent from '../orders/OpenOrderComponent'
    import confirmedOrderComponent from '../orders/ConfirmedOrderComponent'


    export default {
        name: "UserOrders",
        props: ['user'],
        data() {
            return {
                tab: 0,
            }
        },
        computed: {
            orders() {
                return Order.query().where('user_id', this.$route.params.id)
                    .whereHas('invoice', query => {
                        query.where('new', true)
                    }).all()
            },
            hasNewInvoice() {
                return Invoice.query()
                    .where('user_id', this.user.id)
                    .where('new', true)
                    .get().length > 0
            },
            hasInprogressInvoice() {
                return Invoice.query()
                    .where('confirmed', false)
                    .where('completed', false)
                    .get().length > 0
            },
            items() {
                items:[]

                return [
                    {name: 'Nieuwe Bestelling', selectedComponent: newOrderComponent},
/*                    {name: 'Bevestigd', selectedComponent: confirmedOrderComponent},
                    {name: 'Open', selectedComponent: openOrderComponent}*/

                ]
            }
        },
        mounted() {
            Invoice.dispatch('fetchById', {id: this.user.id})
        },
        components: {
            newOrderComponent,
            openOrderComponent,
            confirmedOrderComponent
        }

    }
</script>

<style scoped>
</style>
