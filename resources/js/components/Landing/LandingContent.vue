<template>
    <v-app>
        <v-content>

            <section style="height:100vh;">
                <v-parallax
                        src="/img/header.jpg"
                        style="height:70%;"

                >
                    <v-container flex justify-center align-center>
                        <v-layout column justify-center align-center style="transform:translateY(20%);">
                            <v-flex xs12>
                                <h1 class="white--text mb-2 display-4 text-xs-center text-uppercase hidden-md-and-down">
                                    Artotheek#44</h1>
                                <h2 class="white--text mb-2 text-xs-center text-uppercase  hidden-lg-and-up headertext">
                                    Artotheek#44</h2>
                            </v-flex>
                            <v-flex xs12 class="test mt-4">
                                <v-btn large outlined dark @click="$vuetify.goTo(target, options)">Hoe werkt het</v-btn>
                                <v-btn class="ml-8" large outlined dark @click="$router.push({name:'catalogus'})">onze
                                    catalogus
                                </v-btn>


                            </v-flex>

                        </v-layout>
                    </v-container>
                </v-parallax>
                <v-layout row align-content-center wrap justify-center class="subheading grey--text">
                    <v-flex xs12 class="center">
                        <v-btn large outlined class="grey--text" dark v-on:click="register">Registreer</v-btn>

                    </v-flex>

                    <v-flex xs12 sm4 md8 class="my-3">
                        <tekst1Component
                                v-if="loaded"
                                :tekst="data.tekst1"
                        />
                    </v-flex>

                </v-layout>

            </section>
            <tekst-component v-if="loaded" id="target" :tekstjes="data.tekstjes"/>
            <!-- <base-section
                     id="uitleg"
                     class="secondary"
             >
                 <v-responsive


                         class="mx-auto"
                         max-width="1350"
                 >

                     <v-flex xs12 class="mt-3" id="target">
                         <v-container fluid md="">
                             <v-row>
                                 <v-col

                                 >
                                     <v-card class="elevation-0 transparent">
                                         <v-card-text class="text-xs-center d-flex">

                                             &lt;!&ndash; <v-img src="http://www.tinademeyer.be/artotheek/static/img/logo.png"
                                                     class="justify-space-around"
                                                     contain
                                                     max-height="50"
                                                     width="50"
                                                     v-on:click="mivalti"
                                              ></v-img>
  &ndash;&gt;


                                         </v-card-text>
                                         <v-card-title primary-title class="layout justify-center">
                                             <div class="headline text-xs-center">Mivalti</div>
                                         </v-card-title>
                                         <v-card-text>
                                             Is een woon- en dagcentrum voor volwassenen met een verstandelijke
                                             beperking, gelegen in het Tieltse.
                                             In het dagcentrum komen de cliënten er enkel overdag. Het wonen zorgt voor
                                             de residentiele opvang.
                                             Voor iedereen is er een dagprogramma vraag gestuurd en op maat.
                                             Onder andere is er een gevarieerde atelierwerking, is er sport, is er
                                             begeleid werk, is er snoezelen,
                                             zijn er vormende activiteiten, … .
                                         </v-card-text>
                                     </v-card>
                                 </v-col>
                                 <v-flex xs12 md4>
                                     <v-card class="elevation-0 transparent">
                                         <v-card-text class="text-xs-center d-flex">
                                             <v-img src="https://scontent.fbru1-1.fna.fbcdn.net/v/t1.0-0/c282.2.392.392a/p526x395/12196336_1497468100581185_3430708234125468827_n.jpg?_nc_cat=103&_nc_oc=AQkgKCsyH6hoX4qiZBIzhUc9fejBXo3UoZ_Hj9aoVTjlCWC1NDoyXzCr20p5sd0a0vklnufzIdNpYVfpmeaAx61x&_nc_ht=scontent.fbru1-1.fna&oh=e2f52c783ce7dbf7d2e94b25d028e82e&oe=5E3B1131"
                                                    class="justify-space-around"
                                                    contain
                                                    max-height="50"
                                                    width="50"
                                                    v-on:click="mivalti"
                                             ></v-img>

                                         </v-card-text>
                                         <v-card-title primary-title class="layout justify-center">
                                             <div class="headline">Ateljee44</div>
                                         </v-card-title>
                                         <v-card-text>
                                             Is het artistiek creatie atelier binnen de dagwerking van Mivalti.
                                             De deelnemers komen uit het dagcentrum of het wonen.
                                             In het atelier krijgen de kunstenaars de ruimte om zich artistiek te
                                             ontplooien
                                             in een of meerdere disciplines: tekenen, schilderen, keramiek, grafiek, … .
                                             Ze werken er aan een eigen oeuvre gekenmerkt door een unieke beeldtaal.
                                         </v-card-text>
                                     </v-card>
                                 </v-flex>
                                 <v-flex xs12 md4>
                                     <v-card class="elevation-0 transparent">
                                         <v-card-text class="text-xs-center d-flex">
                                             <v-img src="https://scontent.fbru1-1.fna.fbcdn.net/v/t1.0-9/13962608_1195119797177257_5071919485123924542_n.jpg?_nc_cat=108&_nc_oc=AQmQE_N5hlPkNz_Aw_Nqvdw_kx5wpiZ0hztd617WbHDbzpwSKxXomLUW8Ehmqjzv-dLHPYJYWgXHP04qcOi6rVvx&_nc_ht=scontent.fbru1-1.fna&oh=08ea94a758f6d28551de89798fe47233&oe=5E2B3195"
                                                    class="justify-space-around"
                                                    contain
                                                    max-height="50"
                                                    width="50"
                                                    v-on:click="mivalti"
                                             ></v-img>

                                         </v-card-text>
                                         <v-card-title primary-title class="layout justify-center">
                                             <div class="headline text-xs-center">Artotheek</div>
                                         </v-card-title>
                                         <v-card-text>
                                             Ateljee44 zoekt wegen om de werken gemaakt in het atelier aan het publiek te
                                             tonen,
                                             uit te lenen en soms zelfs te verkopen. Daarom is er Artotheek#44 een
                                             uitleenplek voor een selectie van de gecreëerde kunstwerken.

                                             Word daarom lid van Artotheek#44 en je kunt een mooi en apart kunstwerk en
                                             in je huis hebben.
                                             Je kunt thuis rustig de catalogus bekijken op www.artotheek44.be.

                                             Je kunt je er lid maken een werk reserveren.
                                         </v-card-text>
                                     </v-card>
                                 </v-flex>
                             </v-row>
                         </v-container>
                     </v-flex>
                 </v-responsive>
             </base-section>-->

            <tekst2Component
                    :title="data.tekst2.title"
                    :tekst="data.tekst2.text"
                    v-on:register="register"
            />

            <photo-component v-if="loaded" :photos="data.fotos"/>

            <!--
                        <section>
                            <v-container grid-list-xl>
                                <v-layout row wrap justify-center class="my-5">
                                    <v-flex xs12 sm4>
                                        <v-card class="elevation-0 transparent">
                                            <v-card-title primary-title class="layout justify-center">
                                                <div class="headline">Company info</div>
                                            </v-card-title>
                                            <v-card-text>
                                                Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                                Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac
                                                turpis egestas.
                                                Nullam in aliquet odio. Aliquam eu est vitae tellus bibendum tincidunt.
                                                Suspendisse potenti.
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    <v-flex xs12 sm4 offset-sm1>
                                        <v-card class="elevation-0 transparent">
                                            <v-card-title primary-title class="layout justify-center">
                                                <div class="headline">Contact us</div>
                                            </v-card-title>
                                            <v-card-text>
                                                Cras facilisis mi vitae nunc lobortis pharetra. Nulla volutpat tincidunt ornare.
                                            </v-card-text>
                                            <v-list class="transparent">
                                                <v-list-item>
                                                    <v-list-item-action>
                                                        <v-icon class="blue&#45;&#45;text text&#45;&#45;lighten-2">phone</v-icon>
                                                    </v-list-item-action>
                                                    <v-list-item-content>
                                                        <v-list-item-title>051-405252</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-action>
                                                        <v-icon class="blue&#45;&#45;text text&#45;&#45;lighten-2">place</v-icon>
                                                    </v-list-item-action>
                                                    <v-list-item-content>
                                                        <v-list-item-title>Tielt, BE</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-action>
                                                        <v-icon class="blue&#45;&#45;text text&#45;&#45;lighten-2">email</v-icon>
                                                    </v-list-item-action>
                                                    <v-list-item-content>
                                                        <v-list-item-title>ateljee44@mivalti.be</v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-list>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </section>
            -->


        </v-content>
        <app-alert></app-alert>
    </v-app>
</template>

<script>
    import appAlert from '../Alert.vue'
    //import * as easings from 'vuetify/es5/util/easing-patterns'
    import {EventBus} from "../../Event";
    import photoComponent from './photos'
    import tekstComponent from './tekstjes'
    import tekst1Component from './tekst1'
    import tekst2Component from './tekst2'

    export default {
        name: "LandingContent",
        data() {
            return {
                loaded: false,
                data: null,
                selector: '#target',
                duration: 1000,
                offset: 50,
                //        easing: 'easeInOutCubic',
                //      easings: Object.keys(easings)

            }
        },
        computed: {
            options() {
                return {
                    duration: this.duration,
                    offset: this.offset,
                    //    easing: this.easing
                }
            },
            target() {
                return this.selector
            }
        },
        methods: {
            register() {
                EventBus.$emit('showRegisterDialog')
            },

            mivalti() {
                window.location.href = "https://www.mivalti.be"
            },
        },
        components: {
            appAlert,
            photoComponent,
            tekstComponent,
            tekst1Component,
            tekst2Component
        },
        mounted() {
            axios.get('api/data', {
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                console.log(response.data)
                this.data = (response.data)
                this.loaded = true
            })
        }
    }
</script>

<style scoped>
    >>> main {
        padding-top: 0 !important;
    }

    .center {
        display: flex;
        justify-content: center;
    }

    .center button {
        border-radius: 0;
    }

    >>> .v-parallax__content {
        background-image: linear-gradient(rgba(72, 126, 176, 0.8), rgba(0, 0, 0, 0.7)) !important;

    }

    .v-btn--outlined {
        border-radius: 100px;
    }

    .container {
        display: flex
    }

    .subheading {
        height: 30%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .subheading-text {
        font-size: 2rem;
    }

    @media (max-width: 56.25em) {
        >>> .test {
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .subheading-text {
            font-size: 1rem;
            margin: 0 3rem;
        }

        .headertext {
            font-size: 2.5rem;
            font-weight: 300;
        }

        v-btn__content {
            width: 3rem;
        }
    }


</style>
