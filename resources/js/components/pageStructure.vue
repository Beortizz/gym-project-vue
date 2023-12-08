<template>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <Sidebar/>
            <div class="col py-3">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from "./sidebar.vue";
export default {
    name: "PageStructure",
    components: {
        Sidebar
    },

    mounted() {
        console.log("Component mounted Page.")
    }
}
</script>

<style>
.page {
  display: flex;
}

/* Estilos de container Bootstrap */

</style>
