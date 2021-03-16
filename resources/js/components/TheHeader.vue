<template>
    <header class="header flex items-center py-6 bg-white border-b px-24">
        <nav class="nav">
            <ul class="flex">
                <li class="nav__item">
                    <svg-icon icon="home" class="mr-2"></svg-icon>
                    <router-link class="nav__link" exact to="/home" >Dashboard</router-link>
                </li>
                <li class="nav__item">
                    <svg-icon icon="information-circle" class="mr-2"></svg-icon>
                    <router-link class="nav__link" to="/help/">Help</router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>

import SvgIcon from './base_components/SvgIcon';

export default {
  components: {
    SvgIcon,
  },
};
</script>

<style scoped>

</style>
