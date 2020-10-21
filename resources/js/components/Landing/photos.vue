<template>
    <section id="blog">
        <div class="py-12"></div>

        <v-container>
            <h2 class="display-2 font-weight-bold mb-3 text-uppercase text-center"></h2>



            <v-row >
                <v-col
                        v-for="({ src }, i) in photos"
                        :key="i"
                        cols="12"
                        md="4"
                >
                    <v-img
                            :src="src"
                            class="mb-4"
                            height="275"
                            max-width="100%"
                    ></v-img>

                </v-col>
            </v-row>


        </v-container>

        <div class="py-12"></div>
    </section>
</template>

<script>
    export default {
        name: "photos",
        props:{
            photos:{
                required:true
            }
        }
    }
</script>

<style scoped>

</style>
