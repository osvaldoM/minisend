<template>
    <div v-if="validationErrors" class="rounded bg-red-100 text-red-900">
        <ul class="px-2 py-1 mb-4">
            <li v-for="(value, key, index) in validationErrors"> - {{ value }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        errors: {
            type: Object,
            default: null,
            required: false
        }
    },
    data(){
        return {

        }
    },
    computed: {
        validationErrors(){
            let errors = Object.values(this.errors);
            errors = errors.flat();
            return errors;
        }
    },
}
</script>

<style scoped>

</style>
