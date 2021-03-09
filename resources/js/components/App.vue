<template>
    <div>
        <app-header></app-header>

        <main class="py-header main-content container mx-auto">
            <router-view>

            </router-view>
        </main>
        <app-footer></app-footer>
    </div>
</template>

<script>
import AppFooter from "./AppFooter";
import AppHeader from "./AppHeader";
export default {
    components: {
        AppFooter,
        AppHeader
    }
}
</script>

<style scoped>

</style>
