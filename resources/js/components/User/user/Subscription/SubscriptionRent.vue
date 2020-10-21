<template>
    <div>
        <span class="mdl-chip">
            <span class="mdl-chip__text">Ontlening</span>
        </span>
        <div>{{rent.artwork.name}}</div>
        <div>verloopt op: {{rent.expires}}</div>
        <div>
            <button class="mdl-button mdl-js-button mdl-button--raised">Ontlening stoppen</button>
        </div>
        <div>
            <button class="mdl-button mdl-js-button mdl-button--raised" v-on:click="onClickStopRent">Ontlenen</button>
        </div>
    </div>
</template>

<script>
    import {Api} from "../../../../Api";

    export default {
        name: "SubscriptionRent",
        props: ['rent'],
        data(){
            return{
                api:new Api()
            }
        },
        methods:{
            onClickStopRent(){
                api.post()
            }
        }
    }
</script>

<style scoped>

</style>
