<template>
<v-card >
    <v-toolbar flat color="lime lighten-2">


                <slot name="toolbar"></slot>




    </v-toolbar>
    <v-card-text>
        <v-container>
            <v-card flat>
                <slot name="text"></slot>
            </v-card>
        </v-container>
    </v-card-text>
</v-card>
</template>

<script>
    export default {
        name: "content"
    }
</script>

<style scoped>


</style>
