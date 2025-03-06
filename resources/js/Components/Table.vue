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

const form = useForm({
    area: "",
});

const $toast = useToast();

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
        return props.rows.length;
    } else {
        let values = props.rows.filter((row) => {
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

        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th v-for="column in columns">{{ column }}</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="odd:bg-white even:bg-gray-200 border-b"
                    v-for="row in filteredRows"
                >
                    <td class="py-5" v-for="(property, key) in row">
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
