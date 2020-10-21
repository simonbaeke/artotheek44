// Artwork Model
import {Model} from '@vuex-orm/core'
import Artist from './Artist'
import Reservation from './Reservation'
import Rent from './Rent'
import Type from './Type'

export default class User extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'artworks'
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
            type_id: this.attr(''),
            available: this.attr(null),
            thumbnailurl: this.attr(''),
            detailurl: this.attr(''),
            artist_id: this.attr(''),
            artist: this.belongsTo(Artist, 'artist_id'),
            reservations: this.hasMany(Reservation, 'artwork_id'),
            rents: this.hasMany(Rent, 'artwork_id'),
            type: this.belongsTo(Type, 'type_id'),
            notify: this.boolean(false),
            width: this.attr(''),
            length: this.attr(''),
            height: this.attr(''),
            price: this.attr(null),
            code: this.attr(null),
            forsale: this.boolean(false),
            sold:this.boolean(false)
        }
    }

    get fullname() {
        return `${this.name} ${this.code}`
    }
}

