// User Model
import {Model} from '@vuex-orm/core'
import User from "./User";
import Subscription from "./Subscription";
import Artwork from "./Artwork";
import Order from "./Order";
import Expire from "./Expire";

export default class Reservation extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'reservations'
    }

/*    'id' => $this->id,
    'artwork' => new ArtworkResource($this->artwork),
    'user' => new UserResource($this->subscription->user),
    'expires' => $this->expires,
    'active' => $this->active,
    'subscription_id' => $this->subscription->id*/

    // List of all fields (schema) of the post model. `this.attr` is used
    // for the generic field type. The argument is the default value.
    static fields() {
        return {
            id: this.attr(null),
            user_id: this.attr(''),
            active:this.boolean(false),
            expired:this.boolean(false),
            subscription_id:this.attr(''),
            artwork_id:this.attr(''),
            user: this.belongsTo(User, 'user_id'),
            subscription: this.belongsTo(Subscription, 'subscription_id'),
            artwork:this.belongsTo(Artwork,'artwork_id'),
            expires_at:this.attr(''),
            expire: this.morphOne(Expire, 'expirable_id', 'expirable_type')


        }
    }
}

