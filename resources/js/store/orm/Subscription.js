// Artwork Model
import {Model} from '@vuex-orm/core'
import User from './User'
import Reservation from './Reservation'
import Rent from './Rent'
import Order from "./Order";
import Expire from "./Expire";


export default class Subscription extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'subscriptions'
    }

    static fields() {
        return {
            id: this.attr(null),
            trial: this.attr(''),
            confirmed: this.boolean(false),
            active: this.boolean(false),
            user_id: this.number(0),
            available: this.boolean(false),
            reservations: this.hasMany(Reservation, 'subscription_id'),
            rents: this.hasMany(Rent, 'subscription_id'),
            user: this.belongsTo(User, 'user_id'),
            order: this.morphOne(Order, 'orderable_id', 'orderable_type'),
            expire: this.morphOne(Expire, 'expirable_id', 'expirable_type'),
            number: this.number(''),
            started_at:this.string(''),
            expires_at:this.string('')
        }
    }

    static afterDelete(model) {

        Expire.delete({
            where(expire) {
                return expire.expirable_type === 'Subscription' && expire.expirable_id === model.id
            }
        })

        Order.delete({
            where(order) {
                return order.orderable_type === 'Subscription' && order.orderable_id === model.id
            }
        })

    }
}

