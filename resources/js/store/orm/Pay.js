import {Model} from '@vuex-orm/core'
import Invoice from "./Invoice";
import Order from "./Order";


export default class Pay extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'pays'
    }

    static fields() {
        return {
            id: this.attr(null),
            amount: this.attr(""),
            invoice_id: this.number(""),
            invoice: this.belongsTo(Invoice, 'invoice_id'),
            payable_id: this.attr(null),
            payable_type: this.attr(""),
            payable: this.morphTo('payable_id', 'payable_type')
        }
    }
}

