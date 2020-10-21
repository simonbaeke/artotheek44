import {Model} from '@vuex-orm/core'
import Artwork from "./Artwork";
import Artist from "./Artist";

export default class Sale extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'sales'
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
            user_id:this.attr(''),
            user_info:this.attr(''),
            lastname:this.attr(''),
            phone:this.attr(''),
            artwork_id: this.attr(''),
            artwork: this.belongsTo(Artwork, 'artwork_id'),        }
    }
}
