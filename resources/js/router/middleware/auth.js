import {store} from '../../store'

export default function auth({next, router}) {

    return next();

    if (!store.getters['entities/users/isAdmin']) {
        return router.push({name: 'landing'});
    }

    return next();
}
