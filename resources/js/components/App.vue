<template>
    <div class="relative">
        <app-header></app-header>

        <main class="py-header main-content container mx-auto pb-40">
            <router-view>

            </router-view>
        </main>
        <app-footer></app-footer>
    </div>
</template>

<script>
import AppFooter from './layout/TheFooter';
import AppHeader from './layout/TheHeader';

export default {
  components: {
    AppFooter,
    AppHeader,
  },
};
</script>

<style scoped>

</style>
