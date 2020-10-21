<template>
    <app-main>
        <template slot="title">Orders</template>
        <template slot="content" >
            <app-content class="hidden-print-only">
                <template slot="toolbar">
                    <v-flex xs6>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                prepend-icon=""
                                label="Zoek order"
                                single-line
                                hide-details
                        ></v-text-field>
                    </v-flex>


                </template>
                <template slot="text">
                    <v-data-table

                            :headers="headers"
                            :items="invoices"
                            :loading="loading"
                            :search="search"
                            :rows-per-page-items="rowsPerPage"
                            no-results-text="Geen orders gevonden"
                    >
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">

                            <order-list-item
                                    v-on:showsummary="summaryId=$event"
                                    :invoice="props.item"/>

                        </template>
                    </v-data-table>
                    <order-summary
                            :dialog="summaryId!=null"
                            :id="summaryId"
                            v-on:close="summaryId=null"
                    />
                </template>
            </app-content>

        </template>

    </app-main>
</template>

<script>
    import appMain from '../basis/main'
    import appContent from '../basis/content'
    import orderListItem from './OrderListItem'
    import Invoice from '../../../store/orm/Invoice'
    import orderSummary from './OrderSummaryComponent'


    export default {
        name: "OrderList",
        data() {
            return {
                headers: [
                    {text: 'Id', sortable: true, value: 'id'},
                    {text: 'Gebruiker', sortable: true, value: 'user.fullname'},
                    {text: 'Betaalwijze', sortable: true, value: 'user.fullname'},
                    {text: 'Voldaan', sortable: true, value: 'user.fullname'},
                    {text: 'Verwijderen', sortable: false, value: 'id'}],
                loading: true,
                search: "",
                rowsPerPage: [10],
                summaryId: null
            }
        },
        computed: {
            invoices() {
                return Invoice.query().whereIdIn([206,208]).withAll().get()
            }
        },
        components: {
            appMain,
            appContent,
            orderListItem,
            orderSummary
        },
        mounted() {


            Invoice.dispatch('fetch').finally(()=>{
                this.loading=false
            })
        }
    }
</script>

<style scoped>

</style>
