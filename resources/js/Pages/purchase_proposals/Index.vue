<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Table from "../../Components/Table.vue";

import { usePage } from "@inertiajs/vue3";

let proposals = ref([]);

defineProps({
    proposals: Array,
});

onMounted(() => {
    const { props } = usePage();
    proposals.value = props.proposals;
});

const columns = [
    {
        label: "ID",
        columnName: "id",
        show: false,
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
        label: "Città",
        columnName: "city",
        show: true,
    },
    {
        label: "Prezzo Da",
        columnName: "price_from",
        show: true,
    },
    {
        label: "Prezzo A",
        columnName: "price_to",
        show: true,
    },
    {
        label: "Mq Da",
        columnName: "mq_from",
        show: true,
    },
    {
        label: "Mq A",
        columnName: "mq_to",
        show: true,
    },
    {
        label: "Numero Stanze",
        columnName: "number_rooms",
        show: true,
    },
    {
        label: "Numero Bagni",
        columnName: "number_bathrooms",
        show: true,
    },
    {
        label: "Tipologia Immobile",
        columnName: "type",
        show: true,
    },
    {
        label: "Tipologia Vendita",
        columnName: "sale_type",
        show: false,
    },
    {
        label: "Ascensore",
        columnName: "elevator",
        show: false,
    },
    {
        label: "Giardino",
        columnName: "garden",
        show: false,
    },
    {
        label: "Parcheggio",
        columnName: "parking_space",
        show: false,
    },
    {
        label: "Balcone",
        columnName: "balcony",
        show: false,
    },
];
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center">
            <h2 class="text-3xl mb-10">Elenco Proposte d'Acquisto</h2>
            <a
                :href="route('admin.purchase-proposals.create')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Aggiungi Proposta D'Acquisto
            </a>
        </div>
        <div v-if="proposals.length > 0">
            <Table
                :rows="proposals"
                :columns="columns"
                :data="'purchase-proposals'"
            />
        </div>
        <div v-else>
            <h3 class="text-3xl text-center">
                Nessuna proposta d'acquisto presente
            </h3>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
