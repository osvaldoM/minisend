<template>
    <form v-on:submit="filterEmails" class="search bg-white shadow-md p-4 flex items-center justify-between mb-10 w-1/2">
        <input class="search-input text-black w-full mr-2" v-model="search" type="search" placeholder="Search by sender, recipient or subject"/>
        <button type="submit">
            <svg-icon icon="search" class="bg-blue-700 text-white py-4 px-8 rounded"></svg-icon>
        </button>
    </form>
</template>

<script>
import {globalStore} from "../store";
import SvgIcon from "./base_components/SvgIcon";

export default {
    components: {
        SvgIcon,
    },
    data(){
        return {
            privateState: {

            },
            sharedState: globalStore.state
        }
    },
    methods: {
        async filterEmails(event){
            event.preventDefault();
            event.stopImmediatePropagation();
            globalStore.loadEmails();
        }
    },
    computed: {
        search: {
            get(){
                return this.sharedState.search;
            },
            set(search){
                globalStore.setSearchAction(search);
            }
        }
    }
}
</script>

<style scoped>

</style>
