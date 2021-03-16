<template>
    <div>
        <h1> Activity</h1>

        <search-form :shared-store="store"></search-form>

        <button v-on:click="openAddEmailModal" class="mb-5 bg-blue-700 py-4 px-8 text-white font-bold flex items-center">
            Add email
            <svg-icon class="mr-2" icon="plus"></svg-icon>
        </button>

        <p> List contains <strong class="font-bold">{{ emails ? emails.length : 0 }}</strong> items</p>

        <emails-list :shared-store="store"></emails-list>

        <add-email-modal :is-modal-visible="isAddEmailModalVisible" @close="hideAddEmailModal()"></add-email-modal>
    </div>
</template>

<script>

import SvgIcon from './base_components/SvgIcon';

import EmailsList from './EmailList';
import SearchForm from './SearchForm';
import { createStore } from '../store';
import AddEmailModal from './AddEmailModal';

const store = createStore();

export default {
  components: {
    SearchForm,
    EmailsList,
    SvgIcon,
    AddEmailModal,
  },
  created() {
  },
  mounted() {
  },
  data() {
    return {
      store,
      privateState: {
        isAddEmailModalVisible: false,
      },
      sharedState: store.state,
    };
  },
  methods: {
    openAddEmailModal() {
      this.isAddEmailModalVisible = true;
    },
    hideAddEmailModal() {
      this.isAddEmailModalVisible = false;
    },
  },
  computed: {
    emails() {
      return this.sharedState.paginatedEmails.data;
    },
    isAddEmailModalVisible: {
      get() {
        return this.privateState.isAddEmailModalVisible;
      },
      set(value) {
        this.privateState.isAddEmailModalVisible = value;
      },
    },
  },
  watch: {

  },
};
</script>
