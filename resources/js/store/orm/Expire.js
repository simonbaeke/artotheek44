// Artwork Model
import {Model} from '@vuex-orm/core'
import Order from "./Order";

export default class Expire extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'expire'
    }

    static fields() {
        return {
            id: this.attr(null),
            date: this.attr(""),
            expirable_id: this.number(""),
            expirable_type: this.attr(""),
            expirable: this.morphTo('expirable_id', 'expirable_type'),
            order: this.morphOne(Order, 'orderable_id', 'orderable_type'),

        }
    }

    static afterDelete(model) {

        Order.delete({
            where(order) {
                return order.orderable_type === 'Expire' && order.orderable_id === model.id
            }
        })

    }
}

