export class Filter {
    constructor(data) {
        this.fields = [];


        for (let type  in data) {
            this[data[type].name] = false;
            this.fields.push(data[type].name);

        }

    }

    getFilter() {
        let filterstring = ""

        for (let key in this.fields) {

            if (this[this.fields[key]]) {
                filterstring += this.fields[key]
            }
        }
        return filterstring
    }
}
