<template>
    <HeaderComponent />

    <router-view></router-view>

    <FooterComponent />
</template>

<script>
    import HeaderComponent from '../components/Header.vue';
    import FooterComponent from '../components/Footer.vue';

    export default {
        components: {
            HeaderComponent,
            FooterComponent
        }
    }
</script>

<style>

</style>
