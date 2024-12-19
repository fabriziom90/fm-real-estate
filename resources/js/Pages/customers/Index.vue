<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Table from "../../Components/Table.vue";

import { usePage } from "@inertiajs/vue3";

let customers = ref([]);
const columns = [
    "ID",
    "Nome",
    "Cognome",
    "Email",
    "Telefono",
    "Indirizzo",
    "Tools",
];

onMounted(() => {
    const { props } = usePage();
    customers.value = props.customers;
});
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center">
            <h2 class="text-3xl mb-10">Elenco clienti</h2>
            <a
                :href="route('admin.customers.create')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Aggiungi cliente
            </a>
        </div>
        <div v-if="customers.length > 0">
            <Table :rows="customers" :columns="columns" :data="'customers'" />
        </div>
        <div v-else>
            <h3 class="text-3xl text-center">Nessun cliente presente</h3>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
