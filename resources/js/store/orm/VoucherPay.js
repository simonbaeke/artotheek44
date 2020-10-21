import {Model} from '@vuex-orm/core'
import Pay from "./Pay";
import Voucher from "./Voucher";

export default class VoucherPay extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'voucherPays'
    }

    static fields() {
        return {
            id: this.attr(null),
            voucher_id: this.number(''),
            confirmed: this.boolean(true),
            pay: this.morphOne(Pay, 'payable_id', 'payable_type'),
            voucher:this.belongsTo(Voucher,'voucher_id'),
            date:this.string('')

        }
    }
}

