<template>
    <v-card class="ma-4 elevation-0">
        <v-card-title>Ontlening</v-card-title>
        <v-card-text>
            <div>
                Kunstwerk: {{artwork.name}}
            </div>
            <div>
                Einddatum ontlening: {{rent.expires_at}}
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
    import Artwork from '../../../../store/orm/Artwork'

    export default {
        name: "RentDetail",
        props: {
            rent: {
                required: true
            }
        },
        computed: {
            artwork() {
                return Artwork.find(this.rent.artwork_id)
            }
        }
    }
</script>

<style scoped>

</style>
