<template>
    <div >Abonnement bevestigd, geldig tot <span v-if="expires">{{expires}}</span></div>
</template>

<script>
    import Confirmed from "../../../../store/orm/Confirmed";
    import Expire from "../../../../store/orm/Expire";

    export default {
        name: "ConfirmedComponent",
        props:{
            id:{
                required:true
            }
        },
        computed:{
            confirmed(){
                return Confirmed.find(this.id)
            },

            expires(){
                if (this.confirmed){
                    return Expire.query()
                        .where('expirable_type','Subscription')
                        .where('expirable_id',this.confirmed.subscription_id)
                        .first().date
                }
            }
        },
        mounted(){
            if(Confirmed.find(this.id)==null){
                Confirmed.dispatch('show',{id:this.id})
            }
        }
    }
</script>

<style scoped>

</style>
