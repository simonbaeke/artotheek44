<template>
    <v-flex>Cash betaald: {{this.amount}}€</v-flex>
</template>

<script>
    import Cash from "../../../store/orm/Cash";

    export default {
        name: "CashSummary",
        props: {
            id: {
                required: true
            }
        }, data() {
            return {
                amount: "",
            }
        },
        computed: {
            cash() {
                return Cash.find(this.id)
            }
        },
        mounted() {
            Cash.dispatch('show', this.id).then(response => {
                this.amount = response.data.data.amount

            })
        }

    }
</script>

<style scoped>

</style>
