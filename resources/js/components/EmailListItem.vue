<template>
    <div>
        <h1>Recipient activity</h1>

        <div class="shadow-md rounded bg-white flex p-8 items-start">
            <div class="gravatar mr-8"></div>
            <div class="flex flex-col">
                <h2 class="font-bold text-black"> {{recipient}}</h2>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data(){
        return {
            privateState: {
                emailsToRecipient: null
            }
        }
    },
    props: {},
    async created(){
        const emails = await this.loadEmailsToRecipient();
        this.setEmailsToRecipient(emails);
    },
    methods: {
        setEmailsToRecipient(emails){
            this.privateState.emailsToRecipient = emails;
        },
        async loadEmailsToRecipient(){
            return await axios.get(window.route('emailsToRecipient', {
                'recipient': this.recipient
            }));
        }
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
