<template>
    <div>
        <table class="emails auto w-full">
            <thead>
            <tr>
                <td class="">Status</td>
                <td class="">Recipient</td>
                <td class="">Subject</td>
                <td class="">Date created</td>
                <td class="">Actions</td>
            </tr>
            </thead>
            <tr class="mx-auto shadow bg-white my-4 px-2 border-b" v-for="email in emails">
                <td class="emails-table-column "><span class="rounded-lg bg-gray-200 mr-2 px-4 py-1.5"> {{last(email.statuses).name}}</span></td>
                <td class="emails-table-column">{{email.message.to}}</td>
                <td class="emails-table-column">{{email.message.subject}}</td>
                <td class="emails-table-column">{{email.created_at}}</td>
                <td class="emails-table-column">View</td>
            </tr>
        </table>
    </div>
</template>

<script>

import {last} from 'lodash-es'

    export default {
        components: {
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
            last
        }
    }
</script>
