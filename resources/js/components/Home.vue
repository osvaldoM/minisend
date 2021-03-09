<template>
    <div>
        <h1> Activity</h1>

        <form class="search bg-white shadow-md p-4 flex items-center justify-between mb-10 w-1/2">
            <input class="search-input text-black w-full mr-2" type="search" placeholder="Search by sender, recipient or subject" />
            <button type="submit">
                <svg-icon icon="search" class="bg-blue-700 text-white py-4 px-8 rounded"></svg-icon>
            </button>
        </form>

        <p> List contains <strong class="font-bold">{{emails? emails.length : 0}}</strong> items</p>

        <table class="emails auto w-full">
            <thead class="mb-2">
            <tr class="">
                <td class="font-bold uppercase text-xs emails-table-column">Status</td>
                <td class="font-bold uppercase text-xs emails-table-column">Recipient</td>
                <td class="font-bold uppercase text-xs emails-table-column">Subject</td>
                <td class="font-bold uppercase text-xs emails-table-column">Date created</td>
                <td class="font-bold uppercase text-xs emails-table-column">Actions</td>
            </tr>
            </thead>
            <tr class="mx-auto shadow bg-white my-4 px-2 border-b" v-for="email in emails">
                <td class="emails-table-column text-black">
                    <span v-bind:class="`email-status ${mostRecentStatusClassName(email.statuses)}`">
                        {{mostRecentStatus(email.statuses).name}}
                    </span>
                </td>
                <td class="emails-table-column text-black">{{email.message.to}}</td>
                <td class="emails-table-column text-black">{{email.message.subject}}</td>
                <td class="emails-table-column">{{email.created_at | formatDate}}</td>
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
            <div class="paginator mt-10">
                <span> {{paginatedEmails.from}} - {{paginatedEmails.to}} of {{paginatedEmails.total}}</span>
            <ul v-if="paginatedEmails && paginatedEmails.data" class="page-links flex ml-4">
                <li class="page-link-container" v-for="link in paginatedEmails.links">
                    <button v-bind:disabled="!link.url || link.active" v-on:click="changePage" v-bind:class="`page-link ${link.active ? 'bg-blue-100' : ''}`" :data-url="link.url" v-html="link.label"></button>
                </li>
            </ul>
            </div>
    </div>
</template>

<script>

import {last as _last} from 'lodash-es'
import SvgIcon from "./base_components/SvgIcon";

const statusColor = (status) =>{
    switch (status.name) {
        case 'Sent':
            return 'success-status';
            break;

        case 'Failed':
            return  'failed-status';
            break;

        default: return 'default-status';
    }
}

const mostRecentStatus = (statuses) => {
    return _last(statuses);
};

const mostRecentStatusClassName = (statuses) => {
    return statusColor(mostRecentStatus(statuses));
};
    export default {
        components: {
            SvgIcon,
        },
        created(){
            this.loadEmails();
        },
        mounted() {
        },
        data() {
            return {
               paginatedEmails: {}
            }
        },
        methods: {
            async loadEmails(url){
                const resp = await axios.get(url || window.route('email.index'));
                this.paginatedEmails= resp.data;
            },
            async changePage(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                const url = event.target.getAttribute('data-url');
                if(!url) {
                    return;
                }
                this.loadEmails(url)
            },
            mostRecentStatus,
            mostRecentStatusClassName
        },
        computed: {
            emails() {
                return this.paginatedEmails.data;
            },
        }
    }
</script>
