import axios from "./HTTP";

const store = {
    debug: true,
    state: {
        paginatedEmails: {},
        search: ''
    },
    setPaginatedEmailsAction(paginatedEmails) {
        if (this.debug) console.log('setPaginatedEmailsAction triggered with', paginatedEmails)
        this.state.paginatedEmails = paginatedEmails;
    },
    setSearchAction (search) {
        if (this.debug) console.log('setSearchAction triggered with', search)
        this.state.search = search
    },
    setPerPageAction (perPage) {
        if (this.debug) console.log('setPerPageAction triggered with', perPage)
        this.state.paginatedEmails.perPage = perPage;
    },
    clearMessageAction () {
        if (this.debug) console.log('clearMessageAction triggered')
        this.state.message = ''
    },
    async loadEmails(url){
        return await axios.get(url || window.route('email.index',{
            'per_page': this.state.paginatedEmails ? this.state.paginatedEmails.per_page: '',
            'query': this.state.search
        })).then(resp => this.setPaginatedEmailsAction(resp.data));
    }
}

class Store {
    constructor(){
        Object.assign(this, store);
    }
}

const  createStore = () => new Store();

export {
    store as globalStore,
    createStore
};



//    state(){
//         return{
//             paginatedEmails: {},
//             search: ''
//         };
//     },
