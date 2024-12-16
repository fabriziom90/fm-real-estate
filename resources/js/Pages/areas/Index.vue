<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Table from '../../Components/Table.vue';

import { usePage } from "@inertiajs/vue3";
import Pagination from '../../Components/Pagination.vue';

defineProps({
    message: String,
});


let areas = ref([]);
const columns = ['ID', 'Nome area', 'Tools'];

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
        
        <Table :rows="areas" :columns="columns">
            <td>
                <a
                    href="#"
                    class="tool-button text-white bg-main-blue border-main-blue"
                >
                    <i class="fas fa-eye"></i>
                </a>
                <a
                    href="#"
                    class="tool-button text-white bg-warning border-warning"
                >
                    <i class="fas fa-edit"></i>
                </a>
                <a
                    href="#"
                    class="tool-button text-white bg-danger border-danger"
                >
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </Table>
        
    </AuthenticatedLayout>
</template>
<style lang=""></style>
