<template>
    <v-simple-table
            :dense="dense"
            :fixed-header="fixedHeader"
            :height="height"
    >
        <template v-slot:default>
            <thead>
            <tr>
                <th class="text-left">Naam kunstwerk</th>
                <th class="text-left">Ontleend op</th>
                <th class="text-left">Ontleend tot</th>
                <th class="text-left">Teruggebracht</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in rents" :key="item.id">
                <td>{{ item.artwork.name }}</td>
                <td>{{ item.started_at }}</td>
                <td>{{ item.expires_at }}</td>
                <td>{{ item.returned?item.returned_at: "Nee" }}</td>

            </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    import Rent from '../../../store/orm/Rent'

    export default {
        name: "SubscriptionHistoryTab",
        props: {
            subscription: {
                required: true,
                type: Object
            }
        },
        computed: {
            rents(){
                return Rent.query().where('subscription_id',this.subscription.id)
                    .with('artwork')
                    .get()
            }
        },

        mounted() {
            Rent.dispatch('fetch', {
                subscription: this.subscription.id
            })
        }
    }
</script>

<style scoped>

</style>
