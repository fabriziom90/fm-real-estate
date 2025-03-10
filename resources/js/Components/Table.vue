<script setup>
import { ref, onMounted, computed } from "vue";
import Pagination from "./Pagination.vue";
import Modal from "./Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const perPageOptions = [5, 10, 20, 50, 100];

const props = defineProps({
    rows: Array,
    columns: Array,
    data: String,
});

const baseUrl = ref(window.location.origin);
let search = ref("");
const deletedMessage = ref("");
const confirmationMessage = ref("");
const deleteObj = ref({});
const show = ref(false);
const deleteId = ref(0);
let pagination = ref({ page: 1, perPage: perPageOptions[0] });
const sortColumn = ref(null);
const sortOrder = ref("asc");

const form = useForm({
    area: "",
});

const $toast = useToast();

const sortedRows = computed(() => {
    let sorted = [...props.rows]; // Copia per non modificare direttamente props

    // Se c'è una colonna selezionata per l'ordinamento
    if (sortColumn.value) {
        sorted.sort((a, b) => {
            let valueA = a[sortColumn.value];
            let valueB = b[sortColumn.value];

            if (valueA == null) valueA = ""; // Gestisci null
            if (valueB == null) valueB = "";

            // Confronto in base al tipo di valore
            if (typeof valueA === "string") {
                valueA = valueA.toLowerCase();
                valueB = valueB.toLowerCase();
            }

            if (valueA < valueB) return sortOrder.value === "asc" ? -1 : 1;
            if (valueA > valueB) return sortOrder.value === "asc" ? 1 : -1;
            return 0;
        });
    }

    return sorted;
});

let filteredRows = computed(() => {
    const firstIndex = (pagination.value.page - 1) * pagination.value.perPage;
    const lastIndex = pagination.value.page * pagination.value.perPage;

    if (search.value === "") {
        return sortedRows.value.slice(firstIndex, lastIndex);
    } else {
        let values = sortedRows.value.filter((row) => {
            return Object.values(row)
                .slice(1)
                .some((value) => {
                    if (value != null) {
                        return value
                            .toString()
                            .toLowerCase()
                            .includes(search.value.toLowerCase());
                    }
                });
        });

        return values.slice(firstIndex, lastIndex);
    }
});

const pageNumbers = computed(() => {
    if (search.value === "") {
        return sortedRows.value.length;
    } else {
        let values = sortedRows.value.filter((row) => {
            return Object.values(row)
                .slice(1)
                .some((value) => {
                    if (value != null) {
                        return value
                            .toString()
                            .toLowerCase()
                            .includes(search.value.toLowerCase());
                    }
                });
        });
        return values.length;
    }
});

const changePage = (elem) => {
    pagination.value = elem;
};

const deleteElem = () => {
    show.value = false;
    form.delete(route(`admin.${props.data}.destroy`, deleteObj.value), {
        onSuccess: (resp) => {
            $toast.success("Cancellazione completata", {
                position: "top-right",
                duration: 3000,
            });

            setTimeout(() => {
                location.reload();
            }, 3100);
        },
        onError: (resp) => {
            $toast.error("Cancellazione non completata. Riprova più tardi.", {
                position: "top-right",
                duration: 3000,
            });
        },
    });
};

const showModal = (id) => {
    show.value = true;
    switch (props.data) {
        case "areas":
            deletedMessage.value = "Area cancellata";
            confirmationMessage.value =
                "Sei sicuro di voler cancellare quest'area?";
            deleteObj.value = { area: id };
            break;
        case "customers":
            deletedMessage.value = "Cliente cancellato";
            confirmationMessage.value =
                "Sei sicuro di voler cancellare questo cliente?";
            deleteObj.value = { customer: id };
            break;
    }
};

const sortBy = (column, data) => {
    if (sortColumn.value === column.columnName) {
        // Cambia direzione dell'ordinamento

        sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
    } else {
        // Nuova colonna selezionata, resettare a "asc"
        sortColumn.value = column.columnName;
        sortOrder.value = "asc";
    }
};

const closeModal = () => {
    show.value = false;
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

        <table class="w-full table-fixed">
            <thead>
                <tr>
                    <th v-for="(column, index) in columns">
                        <div class="flex">
                            <span class="w-1/2">{{ column.label }}</span>
                            <span
                                class="flex flex-col w-1/2"
                                v-if="
                                    column.columnName != 'copertina' &&
                                    column.columnName != 'tools'
                                "
                            >
                                <i
                                    class="fas fa-sort"
                                    @click="sortBy(column, data)"
                                    v-if="
                                        sortColumn == null ||
                                        sortColumn != column.columnName
                                    "
                                ></i>
                                <!-- Default (nessun ordinamento) -->
                                <i
                                    class="fas fa-sort-up"
                                    @click="sortBy(column, data)"
                                    v-if="
                                        sortColumn == column.columnName &&
                                        sortOrder == 'asc'
                                    "
                                    :class="
                                        sortColumn == column.columnName &&
                                        sortOrder == 'asc'
                                            ? 'text-main-blue'
                                            : ''
                                    "
                                ></i>
                                <!-- Ordinamento ascendente -->
                                <i
                                    class="fas fa-sort-down"
                                    @click="sortBy(column, data)"
                                    v-if="
                                        sortColumn == column.columnName &&
                                        sortOrder == 'desc'
                                    "
                                    :class="
                                        sortColumn == column.columnName &&
                                        sortOrder == 'desc'
                                            ? 'text-main-blue'
                                            : ''
                                    "
                                ></i>
                                {{ console.log(column.columnName, sortColumn) }}
                                <!-- Ordinamento discendente -->
                            </span>
                        </div>
                        <!-- {{ column }} -->
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="odd:bg-white even:bg-gray-200 border-b"
                    v-for="row in filteredRows"
                >
                    <td class="py-5" v-for="(property, key) in row">
                        <!-- {{ row }} -->
                        <div v-if="key == 'cover_image'">
                            <img
                                :src="
                                    property != null
                                        ? `${baseUrl}/storage/${property}`
                                        : 'https://placehold.co/100x100'
                                "
                                class="preview-image"
                            />
                        </div>
                        <div v-else>
                            {{ property }}
                        </div>
                    </td>
                    <td>
                        <a
                            :href="`/admin/${data}/${row.id}`"
                            class="tool-button text-white bg-main-blue border-main-blue"
                        >
                            <i class="fas fa-eye"></i>
                        </a>
                        <a
                            :href="`/admin/${data}/${row.id}/edit`"
                            class="tool-button text-white bg-warning border-warning"
                        >
                            <i class="fas fa-edit"></i>
                        </a>
                        <button
                            @click="showModal(row.id)"
                            class="tool-button text-white bg-danger border-danger"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
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
    <Modal
        :show="show"
        :message="confirmationMessage"
        @confirmDelete="deleteElem()"
        @close="closeModal()"
    />
</template>
<style>
.preview-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
}
</style>
