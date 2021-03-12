import axios from "./HTTP";

const store = {
    debug: true,
    state: {
        paginatedEmails: {},
        search: '',
        recipient: ''
    },
    setRecipientAction(recipient) {
        if (this.debug) console.log('setRecipientAction triggered with', recipient)
        this.state.recipient = recipient;
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
        console.log('loading emails to: ',this.state.recipient);
        return await axios.get(url || window.route('email.index',{
            'per_page': this.state.paginatedEmails ? this.state.paginatedEmails.per_page: '',
            'query': this.state.search,
            'recipient': this.state.recipient
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
