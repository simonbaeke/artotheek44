import {Model} from '@vuex-orm/core'
import Artwork from "./Artwork";

export default class Type extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'types'
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
            name: this.attr(''),
            code:this.attr(''),
            artworks: this.hasMany(Artwork, 'type_id')
        }
    }
}
