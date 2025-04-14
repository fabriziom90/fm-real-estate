<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Table from "../../Components/Table.vue";

import { usePage } from "@inertiajs/vue3";

let estates = ref([]);

defineProps({
    estates: Array,
});

onMounted(() => {
    const { props } = usePage();
    estates.value = props.estates;
});

const columns = [
    {
        label: "ID",
        columnName: "id",
        show: true,
    },
    {
        label: "Copertina",
        columnName: "cover_image",
        show: true,
    },
    {
        label: "Area",
        columnName: "area",
        show: true,
    },
    {
        label: "Venditore",
        columnName: "customerName",
        show: true,
    },
    {
        label: "Nome",
        columnName: "estateName",
        show: true,
    },
    {
        label: "Tipo",
        columnName: "type",
        show: true,
    },
    {
        label: "Prezzo",
        columnName: "price",
        show: true,
    },
    {
        label: "Mq",
        columnName: "mq",
        show: true,
    },
    {
        label: "Indirizzo",
        columnName: "address",
        show: true,
    },
];
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center">
            <h2 class="text-3xl mb-10">Elenco Immobili</h2>
            <a
                :href="route('admin.estates.create')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Aggiungi Immobile
            </a>
        </div>
        <div v-if="estates.length > 0">
            <Table :rows="estates" :columns="columns" :data="'estates'" />
        </div>
        <div v-else>
            <h3 class="text-3xl text-center">Nessun immobile presente</h3>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
