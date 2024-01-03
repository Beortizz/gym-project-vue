<template>   
    <router-view></router-view>
    <portal-target name="modals" multiple></portal-target>
</template>

<script>
    import PageStructure from "./pageStructure.vue";

    export default {
        components: {
            PageStructure
        },
        mounted() {
            console.log('Component mounted App.')
        }
    }
</script>
