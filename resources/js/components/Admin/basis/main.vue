<template>
    <v-app>
        <v-subheader class="blue--text">
           <h1><slot name="title"></slot></h1>
        </v-subheader>
        <slot name="content"></slot>
    </v-app>

</template>

<script>
    export default {
        name: "main"
    }
</script>

<style scoped>

</style>
