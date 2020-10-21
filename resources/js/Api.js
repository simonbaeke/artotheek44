import axios from 'axios'


export class Api {
    constructor() {

        if (window.localStorage.hasOwnProperty('token')) {
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.localStorage.getItem('token');
        }

        this.error = false;
        this.loading = false;
        this.errorMessage = ""
    }


    fetchUsers(data) {
        return this.get('/users',{params:data});
    }

    fetchUserDetails(id) {
        return this.get('/users/' + id);
    }

    stopreservation(reservation) {
        return this.put('/reservations/' + reservation.id, {
            active: false,
            expires: reservation.expires
        })
    }

    newSubscription(id) {
        return this.post('/subscriptions', {
            user_id: id
        })
    }


    get(url, params) {
        this.onStartLoading();

        return new Promise((resolve, reject) => {
            console.log(url);
            window.axios.get('api' + url, params)
                .then(response => {
                    this.onSuccess(response);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onError(error);
                    reject(error)
                })
        })
    }


    post(url, params) {
        return new Promise((resolve, reject) => {
            axios.post('api' + url, params)
                .then(response => {
                    this.onSuccess(response);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onError(error)
                    reject(error.message);
                })
        })
    }

    put(url, params) {

        this.onStartLoading();
        return new Promise((resolve, reject) => {
            axios.put('api' + url, params)
                .then(response => {
                    this.onSuccess(response);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onError(error)
                    reject(error);
                })
        })
    }

    onStartLoading() {
        this.loading = true;
        this.error = false;
    }

    onLoadingSuccess() {
        this.loading = false;
        this.error = false;
    }

    onLoadingError() {
        this.loading = false;
        this.error = true;
    }

    onSuccess(response) {
        console.log(response);
        this.onLoadingSuccess();

    }

    onError(error) {
        console.log(error.response.data);
        this.errorMessage = error.response.data.message;
        this.onLoadingError();
    }


}
