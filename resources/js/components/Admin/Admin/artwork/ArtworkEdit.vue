<template>
    <v-app>
        <v-subheader>
            <h1 class="mr-3 blue--text">Wijzig Kunstwerk</h1>
        </v-subheader>
        <v-card flat>
            <v-toolbar flat color="lime lighten-2">
                <v-toolbar-title>{{newArtwork.name}}</v-toolbar-title>
                <v-spacer/>
                <v-item-group>
                    <v-btn flat :loading="saving" @click="saveArtwork">Opslaan</v-btn>
                    <v-btn flat @click="$emit('cancel')">Annuleren</v-btn>
                </v-item-group>
            </v-toolbar>
            <v-card-text>
                <v-form>
                    <v-container>
                        <v-layout row wrap>
                            <v-flex xs12 md4>
                                <v-text-field
                                        v-model="newArtwork.name"
                                        label="Titel">
                                </v-text-field>
                            </v-flex>
                            <v-flex xs12 md5 offset-md1>
                                <v-layout row>
                                    <v-flex xs4>
                                        <v-text-field
                                                readonly
                                                v-model="precode"
                                                label="code"/>
                                    </v-flex>

                                    <v-flex xs2>
                                        <v-text-field
                                                readonly

                                                value="-"/>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-text-field
                                                v-model="newArtwork.code"

                                                :append-icon="newArtwork.artist_id!=null&&newArtwork.type_id!=null?'refresh':''"
                                                v-on:click:append="getCode"

                                                type="number"
                                        />
                                    </v-flex>

                                </v-layout>

                            </v-flex>
                        </v-layout>


                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-layout row wrap>
                                    <v-flex xs4 class="pr-2">
                                        <v-text-field label="lengte" v-model="newArtwork.length"></v-text-field>
                                    </v-flex>
                                    <v-flex xs4 class="pr-2">
                                        <v-text-field label="breedte" v-model="newArtwork.width"></v-text-field>
                                    </v-flex>
                                    <v-flex xs4>
                                        <v-text-field label="hoogte" v-model="newArtwork.height"></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <v-layout row wrap>
                                    <v-flex xs4>
                                        <v-checkbox v-model="newArtwork.forsale" label="te koop"></v-checkbox>
                                    </v-flex>
                                    <v-flex xs8>
                                        <v-text-field v-model="newArtwork.price" label="prijs"></v-text-field>
                                    </v-flex>
                                </v-layout>


                                <v-flex xs12>
                                    <v-autocomplete
                                            :items="types"
                                            item-text="name"
                                            item-value="id"
                                            label="Type"
                                            v-model="newArtwork.type_id"
                                            prepend-icon="add"
                                            v-on:click:prepend="addType"

                                    ></v-autocomplete>
                                </v-flex>


                                <v-flex xs12>
                                    <v-autocomplete
                                            :items="artists"
                                            item-text="name"
                                            item-value="id"
                                            label="Artiest"
                                            v-model="newArtwork.artist_id"
                                            prepend-icon="add"
                                            v-on:click:prepend="addArtist"

                                    ></v-autocomplete>
                                </v-flex>
                                <v-flex d-flex xs6 sm6 class="mt-3">
                                    <input type="file" id="Afbeelding"
                                           @change="processFile($event)">
                                </v-flex>

                            </v-flex>

                            <v-flex xs12 sm6>

                                <div v-if="item.image">
                                    <v-img :src="item.image" alt="no image selected" height="300px" contain></v-img>

                                </div>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-form>
            </v-card-text>
        </v-card>

    </v-app>
</template>

<script>
    import Artist from '../../../store/orm/Artist'
    import appContent from '../basis/content'

    export default {
        name: "ArtworkEdit",
        props: ['artwork'],
        data() {
            return {
                forsale: false,
                saving: false,
                createArtist: false,
                createType: false,
                newArtwork: {
                    name: "",
                    type_id: null,
                    artist_id: null,
                    width: "",
                    height: "",
                    length: "",
                    code: "",
                    price: "",
                    forsale: '',
                    thumbnailurl: "",

                },
                item: {
                    image: false
                },
                precode: ""
            }
        },
        methods: {
            createImage(item, file) {
                var image = new Image();
                var reader = new FileReader();

                reader.onload = (e) => {
                    item.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage: function (item) {
                item.image = false;
            },

            processFile(event) {
                this.newArtwork.thumbnailurl = event.target.files[0];
                if (!this.newArtwork.thumbnailurl)
                    return;
                this.createImage(this.item, this.newArtwork.thumbnailurl);
            },

            saveArtwork() {
                this.saving = true;
                let formData = new FormData();
                formData.append('name', this.newArtwork.name);

                if (this.newArtwork.thumbnailurl != undefined){
                    formData.append('thumbnailurl', this.newArtwork.thumbnailurl);

                }

                formData.append('type_id', this.newArtwork.type_id);
                formData.append('artist_id', this.newArtwork.artist_id);
                formData.append('price', this.newArtwork.price);
                formData.append('width', this.newArtwork.width);
                formData.append('length', this.newArtwork.length);
                formData.append('height', this.newArtwork.height);
                formData.append('code', this.newArtwork.code)
                formData.append('forsale', this.newArtwork.forsale)
                formData.append('_method','put')
                formData.append('artwork_id',this.artwork.id)


                this.$store.dispatch('updateArtwork', {id: this.artwork.id, data: formData}).then(response => {


                    this.saving = false;
                    this.$emit('cancel')
                }).catch(error => {
                    console.log(error)
                    this.saving = false
                })
            },
            addArtist() {
                this.createArtist = true;
            },

            addType() {
                this.createType = true;
            },
            fullname(artist) {
                return artist.firstname + " " + artist.lastname
            },
            artistCreated(id) {
                this.createArtist = false
                this.artwork.artist_id = id
            },
            getCode() {
                axios.post('api/artworks/code', {

                    type_id: this.artwork.type_id,
                    artist_id: this.artwork.artist_id

                }).then(response => {
                    this.newArtwork.code = response.data.code
                    this.precode = response.data.precode
                })
            }
        },
        computed: {
            types() {
                return this.$store.getters.getTypes
            },

            artists() {
                return Artist.getters('getAll').map(artist => {
                    return {
                        name: this.fullname(artist),
                        id: artist.id
                    }
                })
            }
        },
        mounted() {
            this.newArtwork = {
                name: this.artwork.name,
                type_id: this.artwork.type_id,
                artist_id: this.artwork.artist_id,
                width: this.artwork.width,
                height: this.artwork.height,
                length: this.artwork.length,
                price: this.artwork.price,
                forsale: this.artwork.forsale,
                code:this.artwork.code.split('-')[2]
            }
            axios.post('api/artworks/code', {

                type_id: this.artwork.type_id,
                artist_id: this.artwork.artist_id

            }).then(response => {
               // this.newArtwork.code = response.data.code
                this.precode = response.data.precode
            })

            axios({
                url:'api/artworks/' + this.artwork.id+'/image',
                method:'GET',
                responseType:'blob'
            }).then(response => {
                console.log(response)
                this.createImage(this.item,response.data)
            })


        },
        components: {
            appContent
        }
    }
</script>

<style scoped>

</style>
