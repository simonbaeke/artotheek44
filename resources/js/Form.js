import {Errors} from "./Errors.js"

export class Form {
    constructor(data) {
        this.originalData = data;
        this.fields = [];
        for (let field  in data) {
            this[field] = data[field];
            this.fields.push(field);
        }

        this._errors = new Errors();
    }

    data() {
        let data = Object.assign({}, this);
        delete data.originalData;
        delete data._errors;
        delete data.fields
        return data;
    }

    reset() {
        for (let field in this.originalData) {
            this[field] = "";

        }
    }

    set(data) {
        for (let field in data) {
            if (this.hasOwnProperty(field)) {
                this[field] = data[field]
            }
        }
    }


    error(field, label) {

        let message = this._errors.get(field)

        if (message != undefined && label != undefined) {
            return message.toString().replace(field, label);
        }
        return message

    }

    setErrors(value) {
        this._errors.record(value);
    }

    clearErrors() {
        this._errors.clear()
    }

    clearError(field) {
        this._errors.clear(field)
    }

    hasError(field) {
        return this._errors.has(field)
    }

    hasErrors() {
        return this._errors.any()
    }

    onSuccess(data) {
        this._errors.clear();
        this.reset();
    }

    onError(errors) {
        this._errors.record(errors)
    }

}
