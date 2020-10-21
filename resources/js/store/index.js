import Vue from 'vue'
import Vuex from 'vuex'
import VuexORM from '@vuex-orm/core'
//orm
import User from './orm/User'
import Artwork from './orm/Artwork'
import Artist from './orm/Artist'
import Reservation from './orm/Reservation'
import Subscription from './orm/Subscription'
import Rent from './orm/Rent'
import Type from './orm/Type'
import Role from './orm/Role'
import RoleUser from './orm/RoleUser'
import Preferences from './orm/Preferences'
import Order from './orm/Order'
import Invoice from './orm/Invoice'
import Pay from './orm/Pay'
import Voucher from './orm/Voucher'
import BankTransfert from './orm/BankTransfert'
import Cash from './orm/Cash'
import Expire from './orm/Expire'
import VoucherPay from './orm/VoucherPay'
import Confirmed from './orm/Confirmed'
import Address from './orm/Address'
import Sale from './orm/Sale'
//store
import users from './user'
import shared from './shared'
import auth from './auth'
import subscription from './subscription'
import reservation from './reservation'
import artwork from './artwork'
import type from './type'
import artist from './artist'
import rent from './rent'
import order from './order'
import invoice from './invoice'
import voucher from './voucher'
import expire from './expire'
import cash from './cash'
import bankTransfert from './banktransfert'
import voucherPay from './voucherpay'
import pay from './pay'
import confirmed from './confirmed'
import roleUser from './roleuser'
import sale from './sale'


Vue.use(Vuex)

// Create new instance of Database.
const database = new VuexORM.Database()


// Register Model and Module. The First argument is the Model, and
// second is the Module.
database.register(User, users)
database.register(Artwork, artwork)
database.register(Artist, artist)
database.register(Reservation, reservation)
database.register(Subscription, subscription)
database.register(Rent, rent)
database.register(Type, type)
database.register(Role)
database.register(RoleUser,roleUser)
database.register(Preferences)
database.register(Order, order)
database.register(Invoice, invoice)
database.register(Pay,pay)
database.register(Voucher, voucher)
database.register(BankTransfert, bankTransfert)
database.register(Cash, cash)
database.register(Expire, expire)
database.register(VoucherPay, voucherPay)
database.register(Confirmed,confirmed)
database.register(Address)
database.register(Sale,sale)


export const store = new Vuex.Store({
    plugins: [VuexORM.install(database)],
    modules: {
        // user: users,
        shared: shared,
        auth: auth,
        subscription: subscription,
        reservation,
        artwork,
        type,
        artist,
        rent,
        order,
        invoice,
        voucher,
        expire,
        cash,
        bankTransfert,
        voucherPay,
        pay,
        confirmed,
        sale
    }
})
