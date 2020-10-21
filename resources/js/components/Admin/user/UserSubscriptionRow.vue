<template>


    <tr v-on:click="dialog=true">
        <td>{{subscription.number.toString().padStart(3,'0')}}</td>
        <td>{{expire?expire.date : 'null'}}</td>
        <td></td>
        <td>{{artwork.name}}</td>
        <td>{{artwork.code}}</td>
        <td>{{expires_at}}</td>

        <subscription-dialog
                :dialog="dialog"
                :subscriptionId=subscription.id
                v-on:close="dialog=false"
        ></subscription-dialog>
    </tr>

</template>

<script>
    import Rent from '../../../store/orm/Rent'
    import Expire from "../../../store/orm/Expire";
    import editSubscriptionComponent from '../subscription/EditSubscriptionComponent'
    import subscriptionDialog from '../subscription/SubscriptionDialog'

    export default {
        name: "UserSubscriptionRow",
        props: {
            subscription: {
                type: Object,
                required: true
            }
        }, data() {
            return {
                dialog: false
            }
        },
        computed: {

            rent() {
                return Rent.query()
                    .where('subscription_id', this.subscription.id)
                    .where('returned',false)
                    .with('artwork')
                    .first()
            },

            expire() {
                return Expire.query()
                    .where('expirable_type', "Subscription")
                    .where('expirable_id', this.subscription.id).first()
            },

            available() {
                return !this.subscription.rents.find(rent => {
                    return rent.returned == 0
                }) && !this.subscription.reservations.find(reservation => {
                    return reservation.active == 1
                })
            },
            artwork() {



                if ( this.rent != null){
                    return this.rent.artwork
                }

                return{
                     name:'',
                    code:''
                }

            },
            expires_at(){
                if ( this.rent != null){
                    return this.rent.expires_at
                }

                return ""
            }

        },
        components: {
            editSubscriptionComponent,
            subscriptionDialog
        },
        mounted() {
            Rent.dispatch('fetch', {subscription: this.subscription.id, returned: false})
                .then(response => {

                })
        }
    }

</script>

<style scoped>
    .verlopen {
        color: red
    }


</style>
