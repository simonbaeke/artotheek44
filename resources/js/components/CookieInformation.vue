<template>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="error">

                <v-toolbar-title>Cookie Informatie</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon dark @click="$emit('close')">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                <p>
                    Wij maken op deze website gebruik van cookies. Een cookie is een eenvoudig klein bestandje dat met
                    pagina’s van deze website wordt meegestuurd en door uw browser op uw harde schrijf van uw computer
                    wordt
                    opgeslagen. De daarin opgeslagen informatie kan bij een volgend bezoek weer naar onze servers
                    teruggestuurd worden.
                </p>
                <p>
                    Via onze website wordt een cookie geplaatst van het Amerikaanse bedrijf Google, als deel van de
                    “Analytics”-dienst. Wij gebruiken deze dienst om bij te houden en rapportages te krijgen over hoe
                    bezoekers de website gebruiken. Google kan deze informatie aan derden verschaffen indien Google
                    hiertoe
                    wettelijk wordt verplicht, of voor zover derden de informatie namens Google verwerken. Wij hebben
                    hier
                    geen invloed op. Wij hebben Google toegestaan de verkregen analytics informatie te gebruiken voor
                    andere
                    Google diensten.
                    De informatie die Google verzamelt wordt zo veel mogelijk geanonimiseerd. Uw IP-adres wordt
                    nadrukkelijk
                    niet meegegeven.
                </p>

                <p>
                    <a href="https://www.google.be/intl/nl/policies/privacy/?fg=1">Klik hier voor meer informatie over
                        het privacybeleid van Google.</a>
                </p>

                <p>
                    Op onze website zijn buttons opgenomen om webpagina’s te kunnen promoten (“liken”) of delen
                    (“tweeten”)
                    op sociale netwerken als Facebook en Twitter. Deze buttons werken door middel van stukjes code die
                    van
                    Facebook respectievelijk Twitter zelf afkomstig zijn. Door middel van deze code worden cookies
                    geplaatst. Wij hebben daar geen invloed op. Leest u de privacyverklaring van Facebook
                    respectievelijk
                    van Twitter (welke regelmatig kunnen wijzigen) om te lezen wat zij met uw (persoons)gegevens doen
                    die
                    zij via deze cookies verwerken.
                </p>


                De informatie die ze verzamelen wordt zo veel mogelijk geanonimiseerd. De informatie wordt overgebracht
                naar en door Twitter, Facebook en Google + opgeslagen op servers in de Verenigde Staten.

                In- en uitschakelen van cookies en verwijdering daarvan
                Meer informatie omtrent het in- en uitschakelen en het verwijderen van cookies kan je vinden in de
                instructies en/of met behulp van de Help-functie van jouw browser.
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "CookieInformation",
        props: {
            dialog: {
                type: Boolean,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
