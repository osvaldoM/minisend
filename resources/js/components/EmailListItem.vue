<template>
    <div>
        <h1>Recipient activity</h1>

        <div class="shadow-md rounded bg-white flex p-8 items-start">
            <div class="gravatar mr-8"></div>
            <div class="flex flex-col">
                <h2 class="font-bold text-black"> {{recipient}}</h2>
            </div>
        </div>

        <h2>Emails history</h2>

        <email-list :shared-store="store"></email-list>

    </div>
</template>

<script>
import axios from "axios";
import EmailList from "./EmailList";
import {createStore} from "../store";

const store = createStore();

export default {
    components: {EmailList},
    data(){
        return {
            privateState: {
                emailsToRecipient: null
            },
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
        }
    }
}
</script>

<style scoped>


</style>
