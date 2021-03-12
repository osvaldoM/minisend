<template>
    <div>
        <h1> Activity</h1>

        <search-form :shared-store="store"></search-form>

        <p> List contains <strong class="font-bold">{{ emails ? emails.length : 0 }}</strong> items</p>

        <emails-list :shared-store="store"></emails-list>
    </div>
</template>

<script>

import SvgIcon from "./base_components/SvgIcon";

import EmailsList from "./EmailList";
import SearchForm from "./SearchForm";
import {createStore} from "../store";

const store = createStore();

export default {
    components: {
        SearchForm,
        EmailsList,
        SvgIcon,
    },
    created(){
    },
    mounted(){
    },
    data(){
        return {
            store:store,
            privateState: {

            },
            sharedState: store.state
        }
    },
    methods: {

    },
    computed: {
        emails(){
            return this.sharedState.paginatedEmails.data;
        }
    },
    watch: {

    }
}
</script>
