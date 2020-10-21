<template>
    <div>Nieuwe ontlening van "{{artwork.name}}" tot {{expire.date}}</div>
</template>

<script>
    import Rent from "@/store/orm/Rent";
    import Artwork from "@/store/orm/Artwork";
    import Expire from "@/store/orm/Expire";

    export default {
        name: "RentComponent",
        props: {
            id: {
                required: true,
                type: Number
            }
        },
        computed: {
            rent() {
                return Rent.find(this.id)
            },
            artwork() {
                return Artwork.find(this.rent.artwork_id)
            },
            expire() {
                return Expire.query()
                    .where('expirable_type', 'Rent')
                    .where('expirable_id', this.id)
                    .first()
            }
        }
    }
</script>

<style scoped>

</style>
