// Artwork Model
import {Model} from '@vuex-orm/core'
import Order from "./Order";
import Subscription from "./Subscription";

export default class Confirmed extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'confirmeds'
    }

    static fields() {
        return {
            id: this.attr(null),
            subscription_id:this.number(null),
            order: this.morphOne(Order, 'orderable_id', 'orderable_type'),
        }
    }

    static afterDelete(model) {

        Order.delete({
            where(order) {
                return order.orderable_type === 'Confirmed' && order.orderable_id === model.id
            }
        })

        Subscription.update({
            id: model.subscription_id,
            confirmed: false
        })

    }
}

