import {Model} from '@vuex-orm/core'
import Pay from "./Pay";

export default class Cash extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'cashs'
    }

    static fields() {
        return {
            id: this.attr(""),
            amount: this.number(0),
            confirmed: this.boolean(true),
            pay: this.morphOne(Pay, 'payable_id', 'payable_type'),
            type:this.string('Cash'),
            date:this.string('')
        }
    }
}

