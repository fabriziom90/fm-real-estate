<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    area: Object,
});
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl">Area {{ props.area.area }}</h2>
            <a
                :href="route('admin.areas.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza aree
            </a>
        </div>
        <div class="flex justify-between items-center">
            Elenco immobili della zona
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
