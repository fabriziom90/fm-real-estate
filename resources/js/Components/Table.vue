<script setup>
import { ref, onMounted, computed } from "vue";
import Pagination from "./Pagination.vue";
import Modal from "./Modal.vue";
import ColumnsFilter from "./ColumnsFilter.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const perPageOptions = [5, 10, 20, 50, 100];

const props = defineProps({
    rows: Array,
    columns: Array,
    data: String,
});

const currentColumns = ref([...props.columns]);
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
        case "estates":
            deletedMessage.value = "Immobile cancellato";
            confirmationMessage.value =
                "Sei sicuro di voler cancellare questo immobile?";
            deleteObj.value = { estate: id };
            break;
        case "purchase-proposals":
            deletedMessage.value = "Proposta d'acquisto cancellata";
            confirmationMessage.value =
                "Sei sicuro di voler cancellare questa proposta d'acquisto";
            deleteObj.value = { purchase_proposal: id };
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

const showHideColumn = (col) => {
    currentColumns.value.find((elem) => {
        if (elem.columnName === col) {
            elem.show = !elem.show;
            console.log(elem.show);
        }
    });
};

const visibleColumns = computed(() => {
    const haveShow = currentColumns.value.every((col) => "show" in col);
    if (haveShow) {
        return currentColumns.value.filter((col) => col.show);
    } else return currentColumns.value;
});

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
        <ColumnsFilter
            :columns="columns"
            @showColumn="showHideColumn"
            v-if="data === 'purchase-proposals'"
        />

        <!-- {{ visibleColumns }} -->
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th v-for="(column, index) in visibleColumns">
                        <div class="flex items-center justify-center">
                            <span class="me-2">{{ column.label }} </span>
                            <span
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

                                <!-- Ordinamento discendente -->
                            </span>
                        </div>
                        <!-- {{ column }} -->
                    </th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="odd:bg-white even:bg-gray-200 border-b"
                    v-for="(row, key) in filteredRows"
                    :key="`row-${key}`"
                >
                    <td class="py-5" v-for="(column, k) in columns" :key="k">
                        <div v-if="k == 'cover_image'">
                            <img
                                :src="
                                    property != null
                                        ? `${baseUrl}/storage/${
                                              row[column.columnName]
                                          }`
                                        : 'https://placehold.co/100x100'
                                "
                                class="preview-image"
                            />
                        </div>
                        <div
                            v-else-if="
                                column.columnName == 'elevator' ||
                                column.columnName == 'garden' ||
                                column.columnName == 'parking_space' ||
                                column.columnName == 'balcony'
                            "
                        >
                            {{ row[column.columnName] == 0 ? "No" : "Sì" }}
                        </div>
                        <div v-else-if="column.columnName == 'sale_type'">
                            {{
                                row[column.columnName] == 1
                                    ? "Vendita"
                                    : "Affitto"
                            }}
                        </div>
                        <div
                            v-else-if="
                                column.columnName == 'price' ||
                                column.columnName == 'price_from' ||
                                column.columnName == 'price_to'
                            "
                        >
                            {{ row[column.columnName] }} €
                        </div>
                        <div v-else-if="column.columnName != 'tools'">
                            {{ row[column.columnName] }}
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
<style scoped>
.preview-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
}

.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #011a90;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(18px);
    -ms-transform: translateX(18px);
    transform: translateX(18px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
