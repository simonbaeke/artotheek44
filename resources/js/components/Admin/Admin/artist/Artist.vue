<template>
    <app-main>
        <template slot="title">Artiesten</template>
        <template slot="content">
            <router-view></router-view>
        </template>
    </app-main>
</template>

<script>
    import Artist from '../../../store/orm/Artist'
    import appMain from '../basis/main'

    export default {
        name: "Artist",
        components:{
            appMain
        }

    }
</script>

<style scoped>

</style>
