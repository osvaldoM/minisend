<template>
    <form v-on:submit="filterEmails" class="search bg-white shadow-md p-4 flex items-center justify-between mb-10 w-1/2">
        <input class="search-input text-black w-full mr-2" v-model="search" type="search" placeholder="Search by sender, recipient or subject"/>
        <button type="submit">
            <svg-icon icon="search" class="bg-blue-700 text-white py-4 px-8 rounded"></svg-icon>
        </button>
    </form>
</template>

<script>
import SvgIcon from './base_components/SvgIcon';

export default {
  props: {
    sharedStore: {
      type: Object,
      default: null,
      required: false,
    },
  },
  components: {
    SvgIcon,
  },
  data() {
    return {
      privateState: {

      },
      sharedState: this.sharedStore.state,
    };
  },
  methods: {
    async filterEmails(event) {
      event.preventDefault();
      event.stopImmediatePropagation();
      this.sharedStore.loadEmails();
    },
  },
  computed: {
    search: {
      get() {
        return this.sharedState.search;
      },
      set(search) {
        this.sharedStore.setSearchAction(search);
      },
    },
  },
};
</script>

<style scoped>

</style>
