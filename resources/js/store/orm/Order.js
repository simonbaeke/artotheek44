// Artwork Model
import {Model} from '@vuex-orm/core'
import User from "./User";
import Invoice from "./Invoice";

export default class Order extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'orders'
    }

    static fields() {
        return {
            id: this.attr(null),
            action: this.string(""),
            amount: this.number(0),
            invoice_id: this.attr(""),
            model: this.string(""),
            orderable_id: this.number(""),
            orderable_type: this.string(""),
            user_id: this.attr(null),
            user: this.belongsTo(User, 'user_id'),
            invoice: this.belongsTo(Invoice, 'invoice_id'),
            orderable: this.morphTo('orderable_id', 'orderable_type')
        }
    }


}

