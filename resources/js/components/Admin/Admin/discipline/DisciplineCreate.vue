<template>
    <app-content>
        <template slot="toolbar">
            <v-toolbar-title>
                <h1>Nieuwe discipline</h1>
            </v-toolbar-title>
            <v-spacer/>
            <v-btn :loading="creating" flat @click="save">Opslaan</v-btn>
            <v-btn :disabled="creating" flat v-on:click="close">Annuleren</v-btn>
        </template>
        <template slot="text">
            <v-container>
                <v-layout row wrap>
                        <v-flex xs12 md5>
                            <v-text-field
                                    v-model="form.name"
                                    label="Naam"
                            />
                        </v-flex>
                        <v-flex xs12 md5 offset-md2>
                            <v-text-field
                                    v-model="form.type_code"
                                    label="Nummer van discpline"
                            />
                        </v-flex>
                </v-layout>
            </v-container>
        </template>
    </app-content>
</template>

<script>
    import appContent from '../basis/content'
    import {Form} from "@/Form";
    import Type from "@/store/orm/Type";

    export default {
        name: "DisciplineCreate",
        data() {
            return {
                form: new Form({
                    name: '',
                    type_code: ''
                }),
                creating: false
            }
        },
        methods: {
            save() {
                this.creating = true
                Type.dispatch('createType', this.form.data()).then(response => {
                    this.creating = false
                    this.close()
                })
            },
            close() {
                this.$router.push({name: 'disciplinelist'})
            }
        },
        components: {
            appContent
        }
    }
</script>

<style scoped>

</style>
