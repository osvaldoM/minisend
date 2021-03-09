<template>
    <div>
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
            SvgIcon
        },
        created(){
            this.loadEmails();
        },
        mounted() {
        },
        data() {
            return {
                emails: []
            }
        },
        methods: {
            async loadEmails(){
                const resp = await axios.get(window.route('email.index'));
                this.emails = resp.data;
            },
            mostRecentStatus,
            mostRecentStatusClassName
        },
        computed: {
        }
    }
</script>
