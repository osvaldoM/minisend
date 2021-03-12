<template>
    <div>
        <router-link to="/" class="inline-flex items-center mb-6 underline text-blue-600">
            <svg-icon class="mr-2" icon="arrow-left"></svg-icon> Back to activity
        </router-link>

        <h1>Recipient activity</h1>

        <div class="shadow-md rounded bg-white flex p-8 items-start mb-8">
            <div class="gravatar mr-8"></div>
            <div class="">
                <h2 class="font-bold text-black"> {{recipient}}</h2>
                <div v-if="mostRecentEmailStatus" class="">
                    <p v-bind:class="`mb-2 email-status ${mostRecentEmailStatusClassName}`">{{mostRecentEmailStatus.name}}</p>
                    <p>On <time>{{mostRecentEmailStatus.created_at | formatDate}}</time> <strong class="font-bold"> {{mostRecentEmailStatus.pivot.status_message}}</strong></p>
                </div>
            </div>
        </div>

        <h2 class="">Emails history</h2>

        <email-list :show-recipient="false" :shared-store="store"></email-list>

    </div>
</template>

<script>
import EmailList from "./EmailList";
import {createStore} from "../store";
import SvgIcon from "./base_components/SvgIcon";
import {mostRecentStatus, mostRecentStatusClassName} from "../Util";


const store = createStore();

export default {
    components: {
        EmailList,
        SvgIcon
    },
    data(){
        return {
            privateState: {
                emailsToRecipient: null
            },
            sharedState: store.state,
            store
        }
    },
    props: {},
    async created(){
        store.setRecipientAction(this.recipient);
    },
    methods: {

    },
    computed: {
        recipient(){
            return this.$route.params.recipient
        },
        emails(){
            return this.sharedState.paginatedEmails.data;
        },
        mostRecentEmailStatus() {
            if(this.emails && this.emails.length) {
                return mostRecentStatus(this.emails[0].statuses);
            }
        },
        mostRecentEmailStatusClassName() {
            return mostRecentStatusClassName(this.emails[0].statuses);
        }
    }
}
</script>

<style scoped>


</style>
