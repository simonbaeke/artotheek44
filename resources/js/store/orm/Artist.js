// Artwork Model
import {Model} from '@vuex-orm/core'
import Artwork from './Artwork'

export default class User extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'artists'
    }

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.

    /*    'id' => $this->id,
        'name' => $this->name,
        'available' => $this->isAvailable(),
        'thumbnailurl' => asset('/storage/img/' . $this->thumbnailurl),
        'artist' => new ArtistResource($this->artist)*/
    static fields() {
        return {
            id: this.attr(null),
            firstname: this.attr(''),
            fullname:this.attr(''),
            lastname: this.attr(''),
            short: this.attr(''),
            bio: this.attr(''),
            artworks: this.hasMany(Artwork, 'artist_id')
        }
    }

}

