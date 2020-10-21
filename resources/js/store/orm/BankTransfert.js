// Artwork Model
import {Model} from '@vuex-orm/core'
import Pay from "./Pay";

export default class BankTransfert extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'bankTransferts'
    }

    static fields() {
        return {
            id: this.attr(null),
            amount: this.number(0),
            statement: this.string(""),
            confirmed: this.boolean(false),
            pay: this.morphOne(Pay, 'payable_id', 'payable_type'),
            type:this.string('Overschrijving'),
            date:this.string('')

        }
    }

    static afterDelete(model) {

        console.log('deleted')
    }
}

