<style module>
.svg {
    /*fill: currentColor;*/
    stroke: currentColor;
    /*height: 1em;*/
    vertical-align: middle;
    /*width: 1em;*/
}
</style>

<template>
    <div class="inline-block" v-html="require(`./../../../svg/hero-icons/outline/${icon}.svg`)"></div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    props: {
        height:{
            type: String,
            default:'1.5em'
        },
        width:{
            type: String,
            default:'1.5em'
        },
        icon: {
            type: String
        }
    },
    mounted() {
        this.$el.firstChild.classList.add(this.$style.svg)
        this.$el.firstChild.setAttribute('height', this.height)
        this.$el.firstChild.setAttribute('width', this.height)
    }
}
</script>
