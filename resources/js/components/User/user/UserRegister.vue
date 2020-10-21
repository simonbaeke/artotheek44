<template>
    <v-dialog
            v-model="showModal"
            persistent
    >
        <v-card class="elevation-1">
            <v-toolbar dark color="primary">
                <v-toolbar-title>Registreren</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                        white
                        icon
                        small
                        v-on:click.prevent="onCancel"
                >
                    <v-icon small>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
                <v-form method="post" action="/register" ref="form">
                    <input type="hidden" name="_token" v-model="token">
                    <v-text-field
                            name="firstname"
                            v-model="form.firstname"
                            label="Voornaam"
                            type="text"
                            :error="form.hasError('firstname')"
                            :error-messages="form.error('firstname','Voornaam')"
                            v-on:focus="form.clearError('firstname')"
                    />
                    <v-text-field
                            v-model="form.lastname"
                            name="lastname"
                            label="Naam"
                            type="text"
                            :error="form.hasError('lastname')"
                            :error-messages="form.error('lastname','Familienaam')"
                            v-on:focus="form.clearError('lastname')"
                            required/>
                    <v-text-field v-model="form.email"
                                  name="email"
                                  label="Email"
                                  type="text"
                                  :error="form.hasError('email')"
                                  :error-messages="form.error('email','Emailadres')"
                                  v-on:focus="form.clearError('email')"
                                  required/>

                    <v-text-field v-model="form.phone"
                                  name="phone"
                                  label="Telefoonnummer"
                                  type="text"
                                  :error="form.hasError('phone')"
                                  :error-messages="form.error('phone','Telefoonnummer')"
                                  v-on:focus="form.clearError('phone')"
                                  required/>

                    <v-text-field
                            name="password"
                            v-model="form.password"
                            label="Paswoord"
                            type="password"
                            :error="form.hasError('password')"
                            :error-messages="form.error('password','Wachtwoord')"
                            required
                    ></v-text-field>

                    <v-text-field
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                            label="Bevestig Paswoord"
                            type="password"
                            required
                            :error="form.hasError('password_confirmation')"
                            :error-messages="form.error('password_confirmation')"
                    ></v-text-field>
                    <v-checkbox
                            label="Schrijf in op de nieuwsbrief"
                            v-model="form.newsletter"
                            name="newsletter"
                    />
                    <v-checkbox
                            v-model="conditions"
                            label="Algemene Voorwaarden"></v-checkbox>

                    <v-btn
                            :disabled="!conditions || loading"
                            color="primary"
                            type="submit"
                            :loading="saving"
                    >Registreer
                    </v-btn>
                </v-form>
            </v-card-text>
            <v-card-actions>

                <v-spacer/>

                <v-dialog
                        v-model="dialog"
                        width="600px"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                                text
                                small
                                v-bind="attrs"
                                v-on="on"
                        >
                            Klik hier om de algemene voorwaarden te lezen
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">Bijzondere voorwaarden</span>
                        </v-card-title>
                        <v-card-text>


                            <h1>1. Kunst ontlenen</h1>

                            <p>- In een (vernieuwd) jaarabonnement zit het lenen van het 1ste kunstwerk inbegrepen. Vanaf een bijkomende ontlening gedurende het jaarabonnement wordt een forfaitaire bijdrage ab 2€ per ontleend kunstwerk aangerekend.</p>

                            <p>- De ontleenperiode bedraagt maximum 6 maanden, éénmalig verlengbaar tot maximum 1 jaar. De ontleenperiode kan nooit de einddatum van het lopende contract overschrijden.</p>

                            <p>- Per ontleenperiode en per abonnement kan er slechts 1 kunstwerk in het bezit van de ontlener zijn.</p>

                            <p>- Een inventaris van de ontleende werken wordt per lidmaatschap bijgehouden.</p>

                            - Bij overschrijding van de ontleenperiode brengt Artotheek#44 bovenop de de reguliere abonnementskost een boete van 2,5€ per week per kunstwerk in rekening.

                            - Artotheek#44 heeft te allen tijde het recht om in dringende gevallen, zoals o.m. beschadiging van de werken, terugvordering door de eigenaar of wanbetaling, de ontleenperiode eerder te beëindigen.

                            - Bij een beperkt aantal werken is een koopoptie mogelijk, mits het aangaan van een

                            - Het staat Artotheek#44 te allen tijde vrij de ontleen- en verkoopprijzen aan te passen.

                            2. Voorschriften

                            - De collectie van Artotheek#44 bestaat uit:

                            o Werken vervaardigd in Ateljee44 – eigendom van Mivalti

                            o Werken van kunstenaars verbonden aan de Stedelijke Kunstacademie Tielt – zelf eigenaar

                            - De ontlener verbindt er zich toe om het transport en het opstellen van het kunstwerk met de nodige voorzichtigheid uit te voeren

                            Praktische richtlijnen:

                            o Artotheek#44 voorziet het kunstwerk van voldoende bescherming en verpakking bij het meenemen

                            o Behoud de oorspronkelijke verpakking en hergebruik deze om het kunstwerk terug te brengen

                            o Vervoer 2D kunstwerken bij voorkeur verticaal, in de hangrichting. Zeker bij kaders met glas is dit belangrijk omdat de kans op breuk dan het kleinst is.

                            o Vermijd aanraking met blote handen. Vuil van de vingers heeft op termijn een kwalijke invloed op het kunstwerk.

                            o Wijzig eventuele ophangsystemen niet

                            o De kunstwerken mogen niet aan extremen blootgsteld worden zoals warmte, koude, fel zonlicht of vochtige ruimtes. Plaats de werken bij voorkeur in rookvrije ruimtes.

                            3. Schade en verzekering

                            De kunstwerken zijn door Artotheek#44 verzekerd tegen alle risico’s. Bij beschadiging, verlies of diefstal van het kunstwerk is de ontlener verplicht om binnen 24u na vaststelling Mivalti of Artotheek#44 op de hoogte te brengen.

                            - Onverminderd de door Artotheek#44 afgesloten verzekering, blijft de ontlener aansprakelijk voor opzettelijke schade (vandalisme), alsook voor alle schade die het gevolg is van fouten door onachtzaamheid of nalatigheid van de ontlener.

                            - In geen geval mag de ontlener zelf het werk (laten) herstellen of het eventuele ophangsysteem wijzigen. Indien hij dit toch doet en daardoor schade veroorzaakt, vervalt de verzekering en dient de ontlener de volledige kostprijs van de herstelling te betalen aan de eigenaar. Indien het werk niet hersteld kan worden, betaalt de ontlener de koopwaarde van het kunstwerk.

                            - De ontlener is te allen tijde verantwoordelijk voor het verlies van het kunstwerk en bijgevolg verplicht om de koopwaarde van het kunstwerk te betalen aan de eigenaar.

                            - De kunstwerken zijn enkel verzekerd op het grondgebied van België. Ontleners die kunstwerken over de landgrenzen brengen, kunnen geen beroep doen op de verzekering. Bij schade verbinden zij zich er toe om de verkoopwaarde van het kunstwerk te betalen aan de eigenaar.

                            - Bij schade aan frames, lijsten, glas of passe-partout worden de volledige herstelkosten in rekening gebracht van de ontlener.

                            4. Algemene bepalingen

                            - Het is de ontlener niet toegestaan om zonder uitdrukkelijke toestemming van de eigenaar kunstwerken in bruikleen op welke wijze dan ook te reproduceren en/of voor commerciële doeleinden te gebruiken.

                            - Artotheek#44 houdt alleen die persoonsgegevens bij die nodig zijn voor het verstrekken van een product. Artotheek#44 behandelt die informatie vertrouwelijk. De ontlener kan te allen tijde de opgeslagen gegevens opvragen en wijzigen.

                            - Alle kosten die voor Artotheek#44 zouden ontstaan ten gevolge van de overtreding van de bepalingen van deze overeenkomst door de ontlener, zijn voor rekening van de ontlener. In geval van overtreding heeft Artotheek#44 het de overeenkomst met de ontlener onmiddellijk stop te zetten.

                            - In geval van betwisting zijn de hoven en de rechtbanken van het gerechtelijk arrondissement van de zetel van Mivalti bevoegd.
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn

                                    text
                                    @click="dialog = false"
                            >
                                Niet akkoord
                            </v-btn>
                            <v-btn

                                    text
                                    @click="agree"
                            >
                                Akkoord
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-card-actions>
        </v-card>
    </v-dialog>


</template>

<script>
    import {Form} from '../../../Form.js'

    export default {
        name: "UserRegister",
        props: ['showModal', 'errors', 'old'],
        data() {
            return {
                dialog:false,
                form: new Form({
                    email: '',
                    password: '',
                    firstname: "",
                    lastname: "",
                    newsletter: false,
                    phone: "",
                    password_confirmation: "",

                }),
                token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                ,
                conditions:
                    false,
                saving:
                    false
            }
        },

        computed: {
            user() {
                return this.$store.getters['entities/users/loggedInUser']
            },
            error() {
                return this.$store.getters.error
            },
            loading() {
                return this.$store.getters.loading
            },
        },

        watch: {
            user(value) {
                if (value !== null && value !== undefined) {
                    // this.$router.push('/')
                }
            },

        },

        methods: {
            url() {
                return axios.defaults.baseURL
            },
            onRegister() {
                this.$refs.form.$el.submit()
            },
            onCancel() {
                this.$emit('close')
                this.form.reset()
                this.form.clearErrors()
            }
            ,

            onDismissed() {
                this.$store.dispatch('clearError')
            },
            agree(){
                this.dialog=false
                this.conditions = true
            }
        },
        mounted() {
            this.form.setErrors(this.errors)
            this.form.set(JSON.parse(this.old))


        }
    }
</script>


<style scoped>
    >>> .v-dialog {
        max-width: 500px;
    }

    @media (max-width: 56.25em) {
        >>> .v-dialog {
            margin: 0;
            max-height: 100%;
            height: 100%;
        }
    }

</style>
