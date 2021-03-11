<template>
    <div>
        <h1> Activity</h1>

        <search-form></search-form>

        <p> List contains <strong class="font-bold">{{ emails ? emails.length : 0 }}</strong> items</p>

        <emails-list></emails-list>
    </div>
</template>

<script>

import SvgIcon from "./base_components/SvgIcon";

import EmailsList from "./EmailList";
import SearchForm from "./SearchForm";
import {globalStore} from "../store";

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
            privateState: {

            },
            sharedState: globalStore.state
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
