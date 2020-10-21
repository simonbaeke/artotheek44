import {Model} from '@vuex-orm/core'

export default class Role extends Model {
    // This is the name used as module name of the Vuex Store.
    static get entity() {
        return 'roles'
    }

    static fields() {
        return {
            id: this.attr(null),
            name: this.attr(''),
        }
    }
}
