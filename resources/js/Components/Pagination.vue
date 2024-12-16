<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    totalRecords: {
        type: Number,
        required: true,
    },
    perPageOptions: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["input"]);

let page = ref(1);
let perPage = ref(props.perPageOptions[0]);

// computed property to show how many pages are calculated based on the number of records and showing results
const pages = computed(() => {
    const cur_page = props.totalRecords % perPage.value;

    if (cur_page > 0) {
        return Math.ceil(props.totalRecords / perPage.value);
    } else {
        return props.totalRecords / perPage.value;
    }
});

// set how many records are displayed in the table
const setPerPage = (num_records) => {
    perPage.value = num_records;

    emit("input", { page: page.value, perPage: num_records });
};

// this function fires at click on arrows. Check which arrow is clicked and set the value of the current page. After that fires and event to the parent component for update the table
const changePage = (page_selected) => {
    switch (page_selected) {
        case 0:
            page.value = page_selected;
            break;
        case 1:
            page.value < pages.value
                ? (page.value = page.value + 1)
                : (page.value = page.value);
            break;
        case -1:
            page.value > 1
                ? (page.value = page.value - 1)
                : (page.value = page.value);
            break;
        case pages:
            page.value = pages.value;
            break;
    }

    emit("input", { page: page.value, perPage: perPage });
};
</script>
<template lang="">
    <div>
        <div class="flex justify-end items-center mt-5">
            <div class="me-3">
                <i class="fas fa-chevron-double-left" @click="changePage(0)" />
                <i class="fas fa-chevron-left" @click="changePage(-1)" />
                <span class="inner-pagination-content">
                    Pagina {{ page }} di {{ pages }}
                </span>
                <i class="fas fa-chevron-right" @click="changePage(1)" />
                <i
                    class="fas fa-chevron-double-right"
                    @click="changePage(pages)"
                />
            </div>
            <div class="ms-3">
                Risultati visualizzati
                <span
                    class="px-3 py-2 rounded-none bg-main-blue mx-1 text-white border-pagination"
                    :class="perPage === amount ? 'active' : ''"
                    v-for="(amount, index) in perPageOptions"
                    :key="index"
                    @click="setPerPage(amount)"
                >
                    {{ amount }}
                </span>
            </div>
        </div>
    </div>
</template>
<style>
.border-pagination {
    border: 6px solid #011a90;
}

.active {
    -webkit-box-shadow: inset 0px 0px 0px 5px #fff;
    box-shadow: inset 0px 0px 0px 5px #fff;
}
</style>
