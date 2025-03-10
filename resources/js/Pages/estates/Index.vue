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
    },
    {
        label: "Copertina",
        columnName: "copertina",
    },
    {
        label: "Area",
        columnName: "area",
    },
    {
        label: "Venditore",
        columnName: "customerName",
    },
    {
        label: "Nome",
        columnName: "estateName",
    },
    {
        label: "Tipo",
        columnName: "type",
    },
    {
        label: "Prezzo",
        columnName: "price",
    },
    {
        label: "Mq",
        columnName: "mq",
    },
    {
        label: "Indirizzo",
        columnName: "address",
    },
    {
        label: "Tools",
        columnName: "tools",
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
