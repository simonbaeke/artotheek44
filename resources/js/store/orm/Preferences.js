import {Model} from '@vuex-orm/core'
import User from './User'

export default class Preferences extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'preferences'
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
            user_id: this.number(''),
            gdpr: this.boolean(false),
            newsletter: this.boolean(false),
            notifications: this.boolean(false),
            user :this.belongsTo(User,'user_id')
        }
    }
}
