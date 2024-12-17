<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    customer: Object,
});
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl">
                Cliente {{ props.customer.name }} {{ props.customer.surname }}
            </h2>
            <a
                :href="route('admin.areas.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza clienti
            </a>
        </div>
        <div class="grid grid-cols-3">
            <div>
                <ul class="list-none">
                    <li class="my-3">
                        <strong>Email:</strong> {{ props.customer.email }}
                    </li>
                    <li class="my-3">
                        <strong>Telefono:</strong> {{ props.customer.phone }}
                    </li>
                    <li class="my-3">
                        <strong>Indirizzo:</strong> {{ props.customer.address }}
                    </li>
                </ul>
            </div>
            <div class="my-3 border-l-2">
                <div class="ps-10">
                    <h2 class="text-2xl">Proposte d'acquisto</h2>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
