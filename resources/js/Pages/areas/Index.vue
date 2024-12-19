<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Table from "../../Components/Table.vue";

import { usePage } from "@inertiajs/vue3";

let areas = ref([]);
const columns = ["ID", "Nome area", "Tools"];

onMounted(() => {
    const { props } = usePage();
    areas.value = props.areas;
});
</script>

<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center">
            <h2 class="text-3xl mb-10">Elenco aree</h2>
            <a
                :href="route('admin.areas.create')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Aggiungi area
            </a>
        </div>
        <div v-if="areas.length > 0">
            <Table :rows="areas" :columns="columns" :data="'areas'" />
        </div>
        <div v-else>
            <h3 class="text-3xl text-center">Nessun'area presente</h3>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
