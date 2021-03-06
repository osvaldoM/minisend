<template>
    <div>
        <table class="emails auto w-full">
            <thead class="mb-2">
            <tr class="">
                <td class="font-bold uppercase text-xs emails-table-column">Status</td>
                <td class="font-bold uppercase text-xs emails-table-column">Sender</td>
                <td v-if="showRecipient" class="font-bold uppercase text-xs emails-table-column">Recipient</td>
                <td class="font-bold uppercase text-xs emails-table-column">Subject</td>
                <td class="font-bold uppercase text-xs emails-table-column">Date created</td>
                <td class="font-bold uppercase text-xs emails-table-column">Actions</td>
            </tr>
            </thead>
            <tr class="mx-auto shadow bg-white my-4 px-2 border-b" v-for="email in emails" v-bind:key="email.id">
                <td class="emails-table-column text-black">
                    <span v-bind:class="`email-status ${statusColor(email.current_status)}`">
                        {{ email.current_status.name }}
                    </span>
                </td>
                <td class="emails-table-column text-black">{{ email.message.from }}</td>
                <td v-if="showRecipient" class="emails-table-column text-black">
                    <router-link class="underline" :to="{ name: 'emailsTo', params: { recipient: email.message.to }}">
                        {{ email.message.to }}
                    </router-link>
                </td>
                <td class="emails-table-column text-black">
                    {{ email.message.subject | truncate(40) }}
                </td>
                <td class="emails-table-column">
                    {{ email.created_at | formatDate }}
                </td>
                <td class="emails-table-column">
                    <router-link :to="{name: 'emailDetails', params: {'id': email.id}}" title="Details">
                        <svg-icon icon="eye"></svg-icon>
                    </router-link>
                </td>
            </tr>
        </table>
        <div class="paginator flex justify-between items-center mt-10">
            <div>
                <label>
                    View
                    <select name="per_page" class="px-4 py-2" v-model="paginatedEmails.per_page">
                        <option disabled value="">Please select one</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </label>
            </div>
            <div class="flex justify-end items-center ml-4">
                <span> {{ paginatedEmails.from }} - {{ paginatedEmails.to }} of {{ paginatedEmails.total }}</span>
                <ul v-if="paginatedEmails && paginatedEmails.data" class="page-links flex ml-4">
                    <li class="page-link-container" v-for="link in paginatedEmails.links" v-bind:key="link.label">
                        <button v-bind:disabled="!link.url || link.active" v-on:click="changePage" v-html="link.label"
                                v-bind:class="`page-link ${link.active ? 'bg-blue-100' : ''}`" :data-url="link.url" ></button>
                    </li>
                </ul>

            </div>
        </div>
    </div>

</template>

<script>
import { statusColor } from '../Util';
import SvgIcon from './base_components/BaseSvgIcon';

export default {
    components: {
        SvgIcon,
    },
    props: {
    sharedStore: {
      type: Object,
      default: null,
      required: true,
    },
    recipient: {
      type: String,
      default: null,
      required: false,
    },
    showRecipient: {
      type: Boolean,
      default: true,
      required: false,
    },
  },
  data() {
    return {
      privateState: {
      },
      sharedState: this.sharedStore.state,
    };
  },
  created() {
    this.sharedStore.loadEmails().catch((error) => {
      this.$toasted.global.load_error({
        message: (error.response ? error.response.data.message : error.message),
        entity: 'emails',
      });
    });
  },
  methods: {
    async changePage(event) {
      const url = event.target.getAttribute('data-url');
      if (!url) {
        return;
      }
      this.sharedStore.loadEmails(url).catch((error) => {
        this.$toasted.global.load_error({
          message: (error.response ? error.response.data.message : error.message),
          entity: 'emails',
        });
      });
    },
    statusColor,
  },
  computed: {
    emails() {
      return this.sharedState.paginatedEmails.data;
    },
    perPage: {
      get() {
        return this.sharedState.paginatedEmails.per_page;
      },
      set() {
        this.sharedStore.setperPage();
      },
    },
    paginatedEmails() {
      return this.sharedState.paginatedEmails;
    },
  },
  watch: {
    perPage() {
      this.sharedStore.loadEmails().catch((error) => {
        this.$toasted.global.load_error({
          message: (error.response ? error.response.data.message : error.message),
          entity: 'emails',
        });
      });
    },
  },
};
</script>

<style scoped>

</style>
