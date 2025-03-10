<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    customer: Object,
});

const baseUrl = ref(window.location.origin);
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl">
                Cliente {{ props.customer.name }} {{ props.customer.surname }}
            </h2>
            <a
                :href="route('admin.customers.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza clienti
            </a>
        </div>
        <div class="flex">
            <div class="w-1/3">
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
            <div class="my-3 border-l-2 w-2/3">
                <div class="ps-10">
                    <h2 class="text-2xl">Proposte d'acquisto</h2>
                </div>
                <hr class="my-5" />
                <div class="ps-10">
                    <h2 class="text-2xl">
                        Immobile di proprietà in vendita presso la nostra
                        agenzia:
                    </h2>
                    <div class="flex">
                        <div class="w-1/2">
                            <img
                                :src="
                                    props.customer.cover_image != null
                                        ? `${baseUrl}/storage/${props.customer.cover_image}`
                                        : `https://placehold.co/400x400`
                                "
                                class="w-100 p-2"
                            />
                        </div>
                        <div class="w-1/2 border-l-2 p-2">
                            <h3>
                                {{ props.customer.estateName }} -
                                {{ props.customer.price }}
                            </h3>
                            <p class="mb-5">
                                <strong>Indirizzo</strong>:
                                {{ props.customer.area }} -
                                {{ props.customer.estateAddress }}<br />
                                <strong>Tipologia</strong>:
                                {{ props.customer.type }}<br />
                                <strong>Metri quadri</strong>:
                                {{ props.customer.mq }}<br />
                                <strong>Tipologia di vendita</strong>:
                                <span
                                    :class="
                                        props.customer.sale_type == 1
                                            ? 'bg-main-blue'
                                            : 'bg-[#002EF6]'
                                    "
                                    class="rounded-full px-3 py-2 text-white"
                                    >{{
                                        props.customer.sale_type == 1
                                            ? "Vendita"
                                            : "Affitto"
                                    }}</span
                                >
                            </p>
                            <a
                                :href="`/admin/estates/${props.customer.id}`"
                                class="tool-button bg-main-blue border-main-blue text-white"
                                >Visualizza immobile</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
