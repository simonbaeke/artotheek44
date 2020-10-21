<template>
    <v-dialog v-model="construction">
        <v-card tile>
            <v-toolbar>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn  text @click="$emit('close')" fab><v-icon>close</v-icon></v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                Under construction
            </v-card-text>
        </v-card>

    </v-dialog>

</template>

<script>
    export default {
        name: "ContstructionDialog",
        props: ['construction']
    }
</script>

<style scoped>

</style>
