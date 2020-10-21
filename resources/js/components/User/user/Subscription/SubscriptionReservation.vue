<template>
    <div>
        <span class="mdl-chip">
            <span class="mdl-chip__text">Reservering</span>
        </span>
        <div>{{reservation.artwork.name}}</div>
        <div>verloopt op: {{reservation.expires}}</div>
        <div>
            <button class="mdl-button mdl-js-button mdl-button--raised" v-on:click="onClickStopReservation">Reservatie stoppen</button>
        </div>
        <div>
            <button class="mdl-button mdl-js-button mdl-button--raised">Ontlenen</button>
        </div>
    </div>
</template>

<script>
    import {Api} from "../../../../Api";
    import {eventBus} from "../../../../app";

    export default {
        name: "SubscriptionReservation",
        props: ['reservation'],
        data(){
            return{
                api:new Api()
            }
        },
        methods:{
            onClickStopReservation(){
                this.api.stopreservation(this.reservation).then(response=>{
                    eventBus.$emit('reservationStopped',response.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
