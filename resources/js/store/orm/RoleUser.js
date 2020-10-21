import {Model} from '@vuex-orm/core'


export default class RoleUser extends Model {
    static get entity() {
        return 'roleUser'
    }

    static fields() {
        return {
            id:this.increment(),
            role_id: this.number(0),
            user_id: this.number(0)
        }
    }
}
