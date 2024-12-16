<script setup>
import { ref, onMounted, computed } from "vue";
import Pagination from "../Components/Pagination.vue";

const perPageOptions = [5, 10, 20, 50, 100];

const props = defineProps({
    rows: Array,
    columns: Array,
});

let search = ref("");
let pagination = ref({ page: 1, perPage: perPageOptions[0] });

let filteredRows = computed(() => {
    const firstIndex = (pagination.value.page - 1) * pagination.value.perPage;
    const lastIndex = pagination.value.page * pagination.value.perPage;

    if (search.value === "") {
        return props.rows.slice(firstIndex, lastIndex);
    } else {
        let values = props.rows.filter((row) => {
            return Object.values(row)
                .slice(1)
                .some((value) => {
                    return value
                        .toString()
                        .toLowerCase()
                        .includes(search.value.toLowerCase());
                });
        });

        return values.slice(firstIndex, lastIndex);
    }
});

const pageNumbers = computed(() => {
    if (search.value === "") {
        return props.rows.length;
    } else {
        let values = props.rows.filter((row) => {
            return Object.values(row)
                .slice(1)
                .some((value) => {
                    return value
                        .toString()
                        .toLowerCase()
                        .includes(search.value.toLowerCase());
                });
        });
        return values.length;
    }
});

const changePage = (elem) => {
    pagination.value = elem;
};
</script>
<template lang="">
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
                    <th v-for="column in columns">{{ column }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in filteredRows">
                    <td v-for="prop in row">{{ prop }}</td>
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
    <Pagination
        :totalRecords="pageNumbers"
        :perPageOptions="perPageOptions"
        v-model="pagination"
        @input="changePage"
    />
</template>
<style lang=""></style>
