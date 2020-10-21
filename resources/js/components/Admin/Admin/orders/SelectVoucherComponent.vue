<template>
    <v-text-field
            v-on:change="checkVoucher"
            v-on:focus="clearCadeaubonError"
            outline
            label="Geef het nummer van de cadeaubon"
            :success="cadeaubonValid && cadeaubonChecked"
            :success-messages="cadeaubonSuccessMessage"
            :error="cadeaubonError"
            :error-messages="cadeaubonErrorMessage"
            v-model="cadeaubonValue"
    ></v-text-field>
</template>

<script>
    export default {
        name: "SelectVoucherComponent",
        props: ['visible'],
        data() {
            return {
                cadeaubonChecked: false,
                cadeaubonValid: false,
                cadeaubonSuccessMessage: "",
                cadeaubonValue: "",
                cadeaubonErrorMessage: "",
                cadeaubonError: false,
                voucherId: ""
            }
        },
        methods: {
            checkVoucher() {
                let vm = this
                this.clearCadeaubonError;
                this.cadeaubonErrorMessage = ""
                axios.post('api/vouchers/check', {
                    code: this.cadeaubonValue
                }).then(response => {
                    this.cadeaubonChecked = true
                    this.cadeaubonValid = true;
                    this.cadeaubonSuccessMessage = 'Cadeaubon is geldig'
                    vm.amount = (response.data.data.amount)
                    vm.voucherid = response.data.data.id
                    if (vm.amount < vm.totalAmount) {
                        console.log('add paymethod')
                    }
                    this.$emit('valid', vm.voucherid)
                    this.$emit('amount', vm.amount)
                }).catch(error => {
                    this.$emit('invalid')
                    this.cadeaubonError = true;
                    if (error.response.status == 400) {
                        this.cadeaubonErrorMessage = error.response.data.message
                    }
                })
            },
            clearCadeaubonError() {
                this.cadeaubonError = false;
                this.cadeaubonErrorMessage = ""
            },
            clear() {
                this.clearCadeaubonError()
                this.voucherid = ""
                this.cadeaubonValue = ""
                this.$emit('reset')
            }
        },
        watch: {
            visible() {
                if (!this.visible) {
                    this.clear()
                }
            }
        }
    }
</script>

<style scoped>

</style>
