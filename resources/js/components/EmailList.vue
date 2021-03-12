<template>
    <div>
        <table class="emails auto w-full">
            <thead class="mb-2">
            <tr class="">
                <td class="font-bold uppercase text-xs emails-table-column">Status</td>
                <td class="font-bold uppercase text-xs emails-table-column">Sender</td>
                <td class="font-bold uppercase text-xs emails-table-column">Recipient</td>
                <td class="font-bold uppercase text-xs emails-table-column">Subject</td>
                <td class="font-bold uppercase text-xs emails-table-column">Date created</td>
                <td class="font-bold uppercase text-xs emails-table-column">Actions</td>
            </tr>
            </thead>
            <tr class="mx-auto shadow bg-white my-4 px-2 border-b" v-for="email in emails">
                <td class="emails-table-column text-black">
                    <span v-bind:class="`email-status ${mostRecentStatusClassName(email.statuses)}`">
                        {{ mostRecentStatus(email.statuses).name }}
                    </span>
                </td>
                <td class="emails-table-column text-black">{{ email.message.from }}</td>
                <td class="emails-table-column text-black">
                    <router-link class="underline" :to="{ name: 'emailsTo', params: { recipient: email.message.to }}">{{ email.message.to }}</router-link>
                </td>
                <td class="emails-table-column text-black">{{ email.message.subject | truncate(40) }}</td>
                <td class="emails-table-column">{{ email.created_at | formatDate }}</td>
                <td class="emails-table-column">
                    <router-link to="/" title="Details">
                        <svg-icon icon="eye"></svg-icon>
                    </router-link>
                    <router-link to="/" title="Retry" v-if="mostRecentStatus(email.statuses).name === 'Failed'">
                        <svg-icon icon="refresh" class="ml-3"></svg-icon>
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
                    <li class="page-link-container" v-for="link in paginatedEmails.links">
                        <button v-bind:disabled="!link.url || link.active" v-on:click="changePage"
                                v-bind:class="`page-link ${link.active ? 'bg-blue-100' : ''}`" :data-url="link.url" v-html="link.label"></button>
                    </li>
                </ul>

            </div>
        </div>
    </div>

</template>

<script>
import {last as _last} from "lodash-es";
import {globalStore} from "../store";
import SvgIcon from "./base_components/SvgIcon";

const statusColor = (status) => {
    switch (status.name) {
        case 'Sent':
            return 'success-status';
            break;

        case 'Failed':
            return 'failed-status';
            break;

        default:
            return 'default-status';
    }
}

const mostRecentStatus = (statuses) => {
    return _last(statuses);
};

const mostRecentStatusClassName = (statuses) => {
    return statusColor(mostRecentStatus(statuses));
};
export default {
    props: {
        sharedStore: {
            type: Object,
            default: null,
            required: true
        },
        recipient: {
            type: String,
            default: null,
            required: false
        }
    },
    components: {
        SvgIcon,
    },
    created(){
        this.sharedStore.loadEmails();
    },
    data(){
        return {
            privateState: {

            },
            sharedState: this.sharedStore.state
        }
    },
    methods: {
        async changePage(event){
            const url = event.target.getAttribute('data-url');
            if(!url){
                return;
            }
            this.sharedStore.loadEmails(url)
        },
        mostRecentStatus,
        mostRecentStatusClassName
    },
    computed: {
        emails(){
            return this.sharedState.paginatedEmails.data;
        },
        perPage: {
            get() {
                return this.sharedState.paginatedEmails.per_page;
            },
            set() {
                this.sharedStore.setperPage();
            }
        },
        paginatedEmails() {
            return this.sharedState.paginatedEmails;
        }
    },
    watch: {
        perPage(per_page){
            this.sharedStore.loadEmails();
        },
    }
}
</script>

<style scoped>

</style>
