<template>
    <app-main>
        <template slot="title">
            Kunstwerken
        </template>
        <template slot="content">
            <app-content>
                <template slot="toolbar">
                    <v-toolbar-title>Nieuw Kunstwerk</v-toolbar-title>
                </template>
                <template slot="text" flat>

                    <v-form>
                        <v-container>
                            <v-layout row wrap>
                                <v-flex xs12 md3>
                                    <v-text-field
                                            v-model="artwork.name"
                                            :error="artwork.hasError('name')"
                                            :error-messages="artwork.error('name','Titel')"
                                            v-on:focus="artwork.clearError('name')"
                                            label="Titel"
                                    />
                                </v-flex>
                                <v-flex xs12 md3>
                                    <v-checkbox v-model="notitle" label="Zonder titel"></v-checkbox>
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
                                                    v-model="code"
                                                    :error="artwork.hasError('code')"
                                                    :error-messages="artwork.error('code')"
                                                    v-on:focus="artwork.clearError('code')"
                                                    :append-icon="artist_id!=null&&type_id!=null?'refresh':''"
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
                                            <v-text-field

                                                    label="Breedte in millimeter"
                                                    v-model="artwork.width"
                                                    :error="artwork.hasError('width')"
                                                    :error-messages="artwork.error('width','Breedte')"
                                                    v-on:focus="artwork.clearError('width')"
                                            />
                                        </v-flex>
                                        <v-flex xs4>
                                            <v-text-field

                                                    label="hoogte in millimeter"
                                                    v-model="artwork.height"
                                                    :error="artwork.hasError('height')"
                                                    :error-messages="artwork.error('height','Hoogte')"
                                                    v-on:focus="artwork.clearError('height')"
                                            />
                                        </v-flex>
                                        <v-flex xs4 class="pr-2">
                                            <v-text-field

                                                    label="Diepte in millimeter"
                                                    :error="artwork.hasError('length')"
                                                    :error-messages="artwork.error('length','Lengte')"
                                                    v-on:focus="artwork.clearError('length')"
                                                    v-model="artwork.length"
                                            />
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row wrap>
                                        <v-flex xs4>
                                            <v-checkbox
                                                    v-model="artwork.forsale"
                                                    label="te koop"></v-checkbox>
                                        </v-flex>
                                        <v-flex xs8>
                                            <v-text-field
                                                    v-model="artwork.price"
                                                    label="Prijs"
                                                    :error="artwork.hasError('price')"
                                                    :error-messages="artwork.error('price','Prijs')"
                                                    v-on:focus="artwork.clearError('price')"
                                            />
                                        </v-flex>
                                    </v-layout>


                                    <v-flex xs12>
                                        <v-autocomplete
                                                :items="types"
                                                item-text="name"
                                                item-value="id"
                                                label="Type"
                                                v-model="type_id"
                                                prepend-icon="add"
                                                v-on:click:prepend="addType"
                                                :error="artwork.hasError('type_id')"
                                                :error-messages="artwork.error('type_id','Type')"
                                        ></v-autocomplete>
                                    </v-flex>


                                    <v-flex xs12>
                                        <v-autocomplete
                                                :items="artists"
                                                item-text="name"
                                                item-value="id"
                                                label="Artiest"
                                                v-model="artist_id"
                                                prepend-icon="add"
                                                v-on:click:prepend="addArtist"
                                                :error="artwork.hasError('artist_id')"
                                                :error-messages="artwork.error('artist_id','Artiest')"

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


                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-item-group>
                            <v-btn flat :loading="saving" @click="saveArtwork">Opslaan</v-btn>
                            <v-btn flat @click="$router.push({name:'artworklist'})">Terug</v-btn>
                        </v-item-group>
                    </v-card-actions>
                    <create-artist-dialog :dialog="createArtist"
                                          v-on:close="artistCreated($event)"></create-artist-dialog>
                    <create-type-dialog :dialog="createType" v-on:close="createType=false"></create-type-dialog>
                </template>

            </app-content>
        </template>

    </app-main>
</template>

<script>
    import createArtistDialog from '../artist/createArtistDialog.vue'
    import createTypeDialog from '../type/createTypeDialog.vue'
    import Artist from '../../../store/orm/Artist'
    import {Form} from "@/Form";
    import {EventBus} from "@/Event";
    import appMain from '../basis/main'
    import appContent from '../basis/content'

    export default {
        name: "ArtworkCreate",
        data() {
            return {
                forsale: false,
                saving: false,
                createArtist: false,
                createType: false,
                type_id: null,
                artist_id: null,
                artwork: new Form({
                    name: "",
                    type_id: null,
                    artist_id: null,
                    thumbnailurl: "",
                    price: "",
                    length: "",
                    width: "",
                    height: "",
                    code: "",
                    forsale: false
                }),
                item: {
                    image: false
                },
                precode: '',
                code: '',
                notitle: false
            }
        },
        watch: {
            type_id() {
                this.artwork.type_id = this.type_id

                if (this.type_id != null && this.artist_id != null) {
                    this.getCode()

                }
            },

            artist_id() {
                this.artwork.artist_id = this.artist_id

                if (this.type_id != null && this.artist_id != null) {
                    this.getCode()
                }
            },
            notitle() {
                if (this.notitle) {
                    this.artwork.name = ""
                }
            }

        }
        , methods: {
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
                this.artwork.thumbnailurl = event.target.files[0];
                if (!this.artwork.thumbnailurl)
                    return;
                this.createImage(this.item, this.artwork.thumbnailurl);
            },

            saveArtwork() {
                this.saving = true;
                let formData = new FormData();
                this.notitle ? formData.append('name', 'Zonder titel') : formData.append('name', this.artwork.name);
                formData.append('thumbnailurl', this.artwork.thumbnailurl);
                formData.append('type_id', this.artwork.type_id);
                formData.append('artist_id', this.artwork.artist_id);
                formData.append('price', this.artwork.price);
                formData.append('width', this.artwork.width);
                formData.append('length', this.artwork.length);
                formData.append('height', this.artwork.height);
                formData.append('code', this.code)
                formData.append('forsale', this.artwork.forsale)


                this.$store.dispatch('createArtwork', formData).then(response => {
                    EventBus.$emit('message', {
                        component: 'notificationSnackbar',
                        message: 'Nieuw kunstwerk aangemaakt'
                    })

                    this.saving = false;
                   // this.$router.push({name: 'artworkdetail', params: {id: response.data.data.id}})
                }).catch(error => {
                    console.log(error.status)

                    this.saving = false

                    if (error.status == 422) {
                        this.artwork.setErrors(JSON.parse(error.response).errors)

                    }
                    else if(error.status == 500){

                    }

                    else {
                        console.log(error)
                        EventBus.$emit('message', {
                            component: "notificationSnackbar",
                            message: "Server error: " + JSON.parse(error.response).message
                        })
                    }


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

                    type_id: this.type_id,
                    artist_id: this.artist_id

                }).then(response => {
                    this.code = response.data.code
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
            this.$store.dispatch('fetchTypes');
            this.$store.dispatch('fetchArtists');
        },
        components: {
            createArtistDialog,
            createTypeDialog,
            appMain,
            appContent
        }
    }
</script>

<style scoped>
</style>
