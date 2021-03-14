<template>
<div>
    <router-link to="/" class="inline-flex items-center mb-6 underline text-blue-600">
        <svg-icon class="mr-2" icon="arrow-left"></svg-icon> Back to activity
    </router-link>

    <h1>Email activity</h1>
    <div class="flex">
        <div v-if="email" class="shadow-md rounded bg-white flex flex-col p-8 items-start mb-8 md:w-4/5 2xl:w-3/5">
            <table>
                <colgroup>
                    <col style="width: 20%;">
                    <col style="width: 80%;">
                </colgroup>
                <tr>
                    <td class="py-4"> Subject</td>
                    <td class="py-4"><strong class="font-bold text-black">{{email.message.subject}}</strong></td>
                </tr>
                <tr>
                    <td class="py-4"> From</td>
                    <td class="py-4">{{email.message.from}}</td>
                </tr>
                <tr>
                    <td class="py-4"> To</td>
                    <td class="py-4">
                        <router-link class="underline text-blue-600" :to="{ name: 'emailsTo', params: { recipient: email.message.to }}">{{ email.message.to }}</router-link>
                    </td>
                </tr>
                <tr>
                    <td class="py-4"> Status</td>
                    <td class="py-4">
                        <span v-bind:class="`email-status ${statusColor(email.current_status)}`">
                        {{ email.current_status.name }}
                        </span>
                    </td>
                </tr>
            </table>

            <div class="flex flex-wrap w-full">
                <div class="w-full">
                    <ul class="flex pl-10 mb-0 list-none flex-wrap pt-3 flex-row border-b">
                        <li class="tab-header last:mr-0">
                            <a class="text-xs font-bold uppercase px-5 py-3 rounded-t block leading-normal bg-white" v-on:click="toggleTabs(1)" v-bind:class="{'border-b': openTab !== 1, 'text-black border border-b-0': openTab === 1}">
                                Text
                            </a>
                        </li>
                        <li class="tab-header last:mr-0">
                            <a class="text-xs font-bold uppercase px-5 py-3 rounded-t block leading-normal bg-white" v-on:click="toggleTabs(2)" v-bind:class="{'border-b': openTab !== 2, 'text-black border border-b-0': openTab === 2}">
                                Html
                            </a>
                        </li>
                    </ul>
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6">
                        <div class="px-4 py-5 flex-auto">
                            <div class="tab-content tab-space max-h-96 overflow-scroll">
                                <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                    {{email.message.text_content}}
                                </div>
                                <div v-html="email.message.html_content" v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ml-10">
            <h5 class="text-black text-base font-bold">Latest events</h5>

            <ol v-if="email" class="timeline">
                <li class="timeline-step" v-for="status in email.statuses">
                    <span class="timeline-icon"></span>
                    <time class="timeline-step-time text-xs">
                        11:19:19
                    </time>
                    <div class="timeline-step-label">
                        <span v-bind:class="`email-status success ${statusColor(status)}`">
                            {{ status.name }}
                        </span>
                        <span class="mt-3"> {{status.message}}</span>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>
</template>

<script>
import SvgIcon from "./base_components/SvgIcon";
import axios from "../HTTP";
import {statusColor} from "../Util";

export default {
    components: {
        SvgIcon,
    },
    data(){
        return {
            privateState: {
                email: null,
                openTab: 1
            }
        }
    },
    created(){
        this.loadEmail(this.$route.params.id);
    },
    computed: {
        email() {
            return this.privateState.email;
        },
        openTab: {
            get() {
                return this.privateState.openTab;
            },
            set(value) {
                this.privateState.openTab = value;
            }
        }
    },
    methods: {
        setEmail(email) {
            this.privateState.email = email;
        },
        async loadEmail(id){
            return await axios.get( window.route('email.show', {
                'email': id
            })).then(resp => this.setEmail(resp.data));
        },
        toggleTabs: function(tabNumber){
            this.privateState.openTab = tabNumber
        },
        statusColor
    }
}
</script>

<style lang="scss">

</style>
