<template>
    <section>
        <v-parallax src="/img/header.jpg" height="380">
            <v-layout column align-center justify-center>
                <div class="headline white--text mb-3 text-xs-center">
                    {{title}}
                </div>
                <em>
                    {{tekst}}
                </em>
                <v-btn
                        class="blue lighten-2 mt-5"
                        dark
                        large

                        v-on:click="$emit('register')"
                >
                    Registreer
                </v-btn>
            </v-layout>
        </v-parallax>
    </section>
</template>

<script>
    export default {
        name: "tekst2",
        props: {
            title: {
                required: true
            },
            tekst: {
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
