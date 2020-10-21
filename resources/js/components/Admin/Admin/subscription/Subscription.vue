<template>
    <app-main>
        <template slot="title">Lidkaarten</template>
        <template slot="content">
            <router-view></router-view>
        </template>
    </app-main>
</template>

<script>
    import appMain from '../basis/main'
    export default {
        name: "Subscription",
        components:{
            appMain
        }
    }
</script>

<style scoped>

</style>
