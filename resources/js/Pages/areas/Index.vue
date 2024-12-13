<script setup>
import { ref, onMounted, computed } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

import { usePage } from "@inertiajs/vue3";
import Pagination from '../../Components/Pagination.vue';

defineProps({
    message: String,
});

const perPageOptions = [5, 10, 20, 50, 100]

let areas = ref([]);
let search = ref("");
let pagination = ref({ page: 1, perPage: perPageOptions[0]});

onMounted(() => {
    const { props } = usePage();
    areas.value = props.areas;
});

const changePage = (elem) => {
    pagination.value = elem;
}

let filteredAreas = computed(() => {
    
    const firstIndex = (pagination.value.page - 1) * pagination.value.perPage;
    const lastIndex = ( pagination.value.page) * pagination.value.perPage;

    if (search.value === "") {
        
        return areas.value.slice(firstIndex, lastIndex);
    } else {
        let values = areas.value.filter((area) => {
            return area.area.includes(search.value);
        });

        return values.slice(firstIndex, lastIndex);
    }
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
        <div class="overflow-x-auto min-h-[500px]">
            Cerca:
            <input
                type="text"
                class="input-sm rounded my-3 ms-1 border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                v-model="search"
                placeholder="Cerca"
            />

            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Area</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="area in filteredAreas">
                        <td>{{ area.id }}</td>
                        <td>{{ area.area }}</td>
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
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination :totalRecords="areas.length" :perPageOptions="perPageOptions" v-model="pagination" @input="changePage"/>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
