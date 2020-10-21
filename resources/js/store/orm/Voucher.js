import {Model} from '@vuex-orm/core'
import User from "./User"
import VoucherPay from "./VoucherPay";

export default class Voucher extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'vouchers'
    }

    static fields() {
        return {
            id: this.attr(null),
            from_id: this.number(null),
            to_id: this.number(null),
            amount: this.number(""),
            code: this.string(""),
            used:this.boolean(false),
            from: this.belongsTo(User, 'from_id'),
            to: this.belongsTo(User, 'to_id'),
            voucherPay: this.hasOne(VoucherPay,'voucher_id'),
            type:this.string('Cadeaubon'),
            koper:this.string('koper')
        }
    }
}

