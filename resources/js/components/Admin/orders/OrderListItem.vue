<template>
    <tr>
        <td v-on:click="$emit('showsummary',invoice.id)">{{invoice.id}}</td>
        <td>{{invoice.user.fullname}}</td>
        <td>{{paymentType}}</td>
        <td>Ja</td>
        <td><v-btn flat fab small><v-icon>delete_outline</v-icon></v-btn></td>

    </tr>

</template>

<script>
    import User from '../../../store/orm/User'
    import Pay from "../../../store/orm/Pay";
    export default {
        name: "OrderListItem",
        props:['invoice'],
        computed:{
            pays(){
              return Pay.query().where('invoice_id',this.invoice.id).with('payable').get()
            },

            paymentType(){
                let string = ""
                 this.invoice.pays.forEach(pay=>{
                    if (pay.payable_type =='BankTransfert'){
                        string = string + " Overschrijving"
                    }else{
                        string = string + pay.payable_type
                    }

                })
                return string
            }
        }



    }
</script>

<style scoped>

</style>
