<template>
    <section id="tekstjes">

        <v-responsive
                class="mx-auto"
                width="444"
        >
            <v-divider class="mb-4"></v-divider>

        </v-responsive>
        <v-container>
            <v-row>
                <v-col
                        v-for="({ text, title }, i) in tekstjes"
                        :key="i"
                        cols="12"
                        md="4"
                >


                    <h3
                            class="font-weight-black mb-4 text-uppercase"
                            v-text="title"
                    ></h3>

                    <div
                            class=" font-weight-light"
                            v-text="text"
                    ></div>
                </v-col>
            </v-row>
        </v-container>

        <div class="py-12"></div>
    </section>

</template>

<script>
    export default {
        name: "tekstjes",
        props:{
            tekstjes:{
                required:true
            }
        }
    }
</script>

<style scoped>

</style>
