<template>
    <div v-if="pay">
        <v-layout row wrap align-center v-if="!loading">
            <v-flex xs10 class="grey--text">

                <component :is="pay.payable_type.toLowerCase() + 'Line'"
                           v-on:loaded="loading=false"
                           v-on:loading="loading=true"
                           :id="pay.payable_id">
                </component>

            </v-flex>
            <v-flex xs2 class="grey--text">
                <v-btn small :loading="deleting" :disabled="deleting" text fab class="grey--text title delete-button">
                    <v-icon text v-on:click="deletePay(id)">delete_outline</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex xs2 offset-xs5 class="mb-4" v-if="loading">
                <v-progress-circular
                        indeterminate
                        size="15"
                        :width="spinnerWidth"
                        color="primary"
                ></v-progress-circular>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import Pay from "../../../store/orm/Pay"
    import voucherpayLine from "./VoucherPayLine"
    import cashLine from "./CashLine"
    import banktransfertLine from "./BankTransfertLine"

    export default {
        name: "PayLineComponent",
        props: {
            id: {
                required: true
            }
        },
        data() {
            return {
                deleting: false,
                loading: false,
                spinnerWidth: 1
            }
        },
        computed: {
            pay() {
                return Pay.find(this.id)

            }
        },
        methods: {
            deletePay() {
                let vm=this
                let deletedPay  = this.pay
                this.deleting = true
                let entity = this.lowerFirstLetter(this.pay.payable_type) + 's'

                Pay.dispatch('destroy', {id: this.id}).then(response => {

                    this.$store.dispatch('entities/'+entity+'/delete', { where: deletedPay.payable_id })
                })
            },
            lowerFirstLetter(string) {
                return string.charAt(0).toLowerCase() + string.slice(1);
            }


        },
        components: {
            voucherpayLine,
            cashLine,
            banktransfertLine
        }
    }
</script>

<style scoped>
    .delete-button {
        margin: 0;
    }
</style>
