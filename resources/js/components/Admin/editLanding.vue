<template>
    <appContent>
        <template slot="toolbar">
            Foto's en text op voorpagina aanpasssen
            <v-spacer/>
            <v-btn text
                   v-on:click="save"
            >Opslaan
            </v-btn>
            <v-btn text
                   v-on:click="get">Ongedaan maken
            </v-btn>
        </template>
        <template slot="text">
            <v-tabs
                    v-model="tab"
            >
                <v-tab>Eerste tekst</v-tab>
                <v-tab>Tekstjes hoe het werkt</v-tab>
                <v-tab>Tekst op foto</v-tab>
                <v-tab>Fotos</v-tab>

            </v-tabs>
            <v-tabs-items
                    v-model="tab"
            >
                <v-tab-item>
                    <v-textarea
                            v-model="tekst1"/>
                </v-tab-item>
                <v-tab-item>
                    <v-container>
                        <v-card class="elevation-0">
                            <v-card-title>Tekstjes hoe het werkt</v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row
                                            justify="space-around"
                                    >
                                        <v-col
                                                v-for="(tekst,i) in tekstjes" :key="i"
                                                :cols="tekstjes.length"
                                        >
                                            <v-text-field
                                                    v-model="tekst.title"
                                            />
                                            <v-textarea

                                                    v-model="tekst.text"
                                                    auto-grow

                                            />
                                        </v-col>
                                    </v-row>
                                </v-container>

                            </v-card-text>

                        </v-card>

                    </v-container>
                </v-tab-item>
                <v-tab-item>
                    <v-text-field
                            v-model="tekst2.title"
                    />
                    <v-textarea
                            v-model="tekst2.text"/>
                </v-tab-item>
                <v-tab-item>
                    <v-container>
                        <v-card class="elevation-0">
                            <v-card-title>
                                Foto's
                            </v-card-title>
                            <v-card-text>
                                <v-container fluid>
                                    <v-row v-for="line,i in photos" :key="i" text>
                                        <v-col md="8">
                                            <v-textarea
                                                    v-model="line.src"
                                            />
                                        </v-col>
                                        <v-col md="4">

                                            <v-img :src="line.src"
                                                   height="150"
                                                   max-width="250"
                                                   contain
                                                   d-flex
                                                   justify-center
                                                   align-center

                                            />
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                        </v-card>
                    </v-container>
                </v-tab-item>

            </v-tabs-items>


        </template>
    </appContent>
</template>

<script>
    import appContent from './basis/content'

    export default {
        name: "editLanding",
        data() {
            return {
                photos: [],
                tekstjes: [],
                tekst1: [],
                tekst2: [],
                tab: null,
                items: ['Eerste tekst', 'Fotoos', 'Tekstjes']
            }
        },
        methods: {
            save() {
                axios.post('/api/data', {
                    data: JSON.stringify({
                        'fotos': this.photos,
                        'tekstjes': this.tekstjes,
                        'tekst1': this.tekst1,
                        'tekst2': this.tekst2
                    })
                })
            },
            get() {
                axios.get('/api/data').then(response => {
                    this.photos = response.data.fotos
                    this.tekstjes = response.data.tekstjes
                    this.tekst1 = response.data.tekst1
                    this.tekst2 = response.data.tekst2
                })
            }
        },
        components: {
            appContent
        },
        mounted() {

            this.get()
        }
    }

</script>

<style scoped>

</style>
