<template>
    <v-item-group>
        <v-chip>{{count}}</v-chip>
        <v-btn flat icon
               v-on:click="$emit('down')"
               :disabled="!down">
            <v-icon>remove</v-icon>
        </v-btn>
        <v-btn flat icon v-on:click="$emit('up')"
               :disabled="!up">
            <v-icon>add</v-icon>
        </v-btn>
    </v-item-group>
</template>

<script>
    export default {
        name: "CountButton",
        props: {
            count: {
                type: Number,
                required: true
            },
            up: {
                type: Boolean,
                required: true
            },
            down: {
                type: Boolean,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
