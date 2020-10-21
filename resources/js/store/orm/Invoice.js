import {Model} from '@vuex-orm/core'
import Order from "./Order";
import User from "./User"
import Pay from "./Pay"

export default class Invoice extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'invoices'
    }

    static fields() {
        return {
            id: this.attr(null),
            user_id: this.number(null),
            pays: this.hasMany(Pay, 'invoice_id'),
            orders: this.hasMany(Order, 'invoice_id'),
            user: this.belongsTo(User, 'user_id'),
            confirmed: this.boolean(false),
            open: this.boolean(false),
            total_amount: this.number(0),
            payed_amount: this.number(0)
        }
    }
}

