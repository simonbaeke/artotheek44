<template>
    <app-content>
        <template slot="toolbar">
            <v-spacer/>
            <v-btn @click="$router.push({name:'disciplinecreate'})" flat>Nieuwe discpline</v-btn>
        </template>
        <template slot="text">
            <v-data-table
                    :items="types"
                    :headers="headers"
                    :rows-per-page-items="rowsPerPage"
            >
                <template slot="items" slot-scope="props">

                    <discipline-list-row :type="props.item"/>

                </template>
            </v-data-table>
        </template>
    </app-content>
</template>

<script>
    import appContent from '../basis/content'
    import disciplineListRow from './DisciplineListRow'
    import Type from "@/store/orm/Type";

    export default {
        name: "DisciplineList",
        data() {
            return {
                headers: [
                    {text: 'Naam', sortable: true, value: 'name'},
                    {text: 'Code', sortable: true, value: 'code'}
                ],
                rowsPerPage: [10]
            }
        },
        computed: {
            types() {
                return Type.all()
            }
        },
        components: {
            appContent,
            disciplineListRow
        }
    }
</script>

<style scoped>

</style>
