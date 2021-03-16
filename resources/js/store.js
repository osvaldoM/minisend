import { random } from 'lodash-es/number';
import axios from './HTTP';

const generateStoreId = () => {
  const randomNumber = random(111, 999);
  return `#${new Date().getTime()}-${randomNumber}`;
};

class Store {
  constructor(id) {
    this.id = id || generateStoreId();
    this.debug = true;
    this.state = {
      paginatedEmails: {
        per_page: 10,
      },
      search: '',
      recipient: '',
    };
  }

  setRecipientAction(recipient) {
    if (this.debug) console.log(this.id, ':setRecipientAction triggered with', recipient);
    this.state.recipient = recipient;
  }

  setPaginatedEmailsAction(paginatedEmails) {
    if (this.debug) console.log(this.id, ':setPaginatedEmailsAction triggered with', paginatedEmails);
    this.state.paginatedEmails = paginatedEmails;
  }

  setSearchAction(search) {
    if (this.debug) console.log(this.id, ':setSearchAction triggered with', search);
    this.state.search = search;
  }

  setPerPageAction(perPage) {
    if (this.debug) console.log(this.id, ':setPerPageAction triggered with', perPage);
    this.state.paginatedEmails.perPage = perPage;
  }

  clearMessageAction() {
    if (this.debug) console.log(this.id, ':clearMessageAction triggered');
    this.state.message = '';
  }

  async loadEmails(url) {
    return axios.get(url || window.route('email.index', {
      per_page: this.state.paginatedEmails ? this.state.paginatedEmails.per_page : '',
      query: this.state.search,
      recipient: this.state.recipient,
    })).then((resp) => this.setPaginatedEmailsAction(resp.data));
  }
}

const globalStore = new Store('global');

const createStore = () => new Store();

export {
  globalStore,
  createStore,
};
