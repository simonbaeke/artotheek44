<template>
    <app-main>
        <template slot="title">
            Cadeaubonnen
        </template>
        <template slot="content">
            <app-content>
                <template slot="toolbar">
                    <v-flex xs6>
                        <v-text-field
                                v-model="search"
                                append-icon="search"
                                label="Zoek cadeaubon"
                                single-line
                                hide-details
                        ></v-text-field>
                    </v-flex>
                    <v-spacer/>
                    <v-btn text v-on:click="createNewVoucher">Nieuwe bon</v-btn>
                    <v-btn text v-on:click="createOldVoucher">Bestaande bon</v-btn>
                </template>
                <template slot="text">
                    <v-data-table
                            :headers="headers"
                            :items="vouchers"
                            :loading="loading"
                    >
                        <template slot="items" slot-scope="props">
                            <td>{{props.item.id}}</td>
                            <td> {{props.item.id}}</td>
                            <td>{{ props.item.to!=null?props.item.to.firstname:"" }} {{
                                props.item.to!=null?props.item.to.lastname:"" }}
                            </td>
                            <td>{{ props.item.amount }}</td>
                            <td>
                                {{ props.item.used?'Gebruikt':'Nog niet gebruikt' }}
                            </td>

                            <td>{{ props.item.code }}</td>
                        </template>
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>

                    </v-data-table>
                </template>
            </app-content>
            <createVoucherDialog
                    :dialog="showCreateVoucherDialog"
                    :newVoucher="newVoucher"
                    v-on:close="showCreateVoucherDialog=false"/>
        </template>


    </app-main>

</template>

<script>
    import Voucher from '../../../store/orm/Voucher'
    import createVoucherDialog from './CreateVoucherDialog'
    import appMain from '../basis/main'
    import appContent from '../basis/content'

    export default {
        name: "VoucherList",
        data() {
            return {
                headers: [
                    {text: 'Id', value: 'id', sortable: false},
                    {text: 'Geschonker door', value: 'koper'},
                    {text: 'Gebruikt door', value: 'to.fullname'},
                    {text: 'Bedrag', value: 'amount'},
                    {text: 'Gebruikt'},
                    {text: 'Code', value: 'code'}
                ],
                showCreateVoucherDialog: false,
                search: "",
                loading: false,
                newVoucher: false

            }
        }, methods: {
            createNewVoucher() {
                this.showCreateVoucherDialog = true
                this.newVoucher = true
            },
            createOldVoucher() {
                this.showCreateVoucherDialog = true
                this.newVoucher = false
            }
        },
        computed: {
            vouchers() {
                return Voucher.query().with('from').with('to').get();
            }
        },
        mounted() {
            if (this.vouchers.length == 0) {
                this.loading = true
            }

            Voucher.dispatch('fetch').finally(() => this.loading = false)
        },
        components: {
            createVoucherDialog,
            appMain,
            appContent
        }
    }
</script>

<style scoped>

</style>
