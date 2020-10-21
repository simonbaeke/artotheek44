// User Model
import {Model} from '@vuex-orm/core'
import User from "./User";
import Subscription from "./Subscription";
import Artwork from "./Artwork";
import Order from "./Order";
import Expire from "./Expire";

export default class Rent extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'rents'
    }

    static fields() {
        return {
            id: this.attr(null),
            user_id: this.number(''),
            returned: this.boolean(false),
            started_at: this.attr(''),
            returned_at: this.attr(''),
            expires_at:this.attr(''),
            subscription_id: this.number(''),
            artwork_id: this.number(''),
            user: this.belongsTo(User, 'user_id'),
            subscription: this.belongsTo(Subscription, 'subscription_id'),
            artwork: this.belongsTo(Artwork, 'artwork_id'),
            order: this.morphOne(Order, 'orderable_id', 'orderable_type'),
            expire: this.morphOne(Expire, 'expirable_id', 'expirable_type'),
            subscriptionnumber: this.attr('')

        }

    }


    get expired () {
        return Date.parse( this.expires_at) < Date.now()
    }

    static afterDelete(model) {

        Expire.delete({
            where(expire) {
                return expire.expirable_type === 'Rent' && expire.expirable_id === model.id
            }
        })

        Order.delete({
            where(order) {
                return order.orderable_type === 'Rent' && order.orderable_id === model.id
            }
        })

        Subscription.update({
            id: model.subscription_id,
            available: true
        })

        Artwork.update({
            where: model.artwork_id
        }, {
            data: {available: false}
        })
    }
}

