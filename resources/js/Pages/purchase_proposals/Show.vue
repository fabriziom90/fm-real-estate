<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Carousel from "../../Components/Carousel.vue";

const props = defineProps({
    purchase_proposal: Object,
    estates: Array,
});
</script>
<template lang="">
    <AuthenticatedLayout>
        <div>
            <div class="flex justify-between mb-10">
                <div>
                    <h2 class="text-3xl mb-3">Dettaglio proposta d'acquisto</h2>
                    <div class="mb-3">
                        Cliente: {{ purchase_proposal.customerName }}
                    </div>
                    <div class="mb-3">Caratteristiche:</div>
                    <span
                        v-if="purchase_proposal.elevator"
                        class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                        title="Ascensore"
                    >
                        <i class="fa-solid fa-elevator"></i>
                    </span>
                    <span
                        v-if="purchase_proposal.garden"
                        class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                        title="Giardino"
                    >
                        <i class="fa-solid fa-tree"></i>
                    </span>
                    <span
                        v-if="purchase_proposal.parking_space"
                        class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                        title="Parcheggio/Posto auto"
                    >
                        <i class="fa-solid fa-square-parking"></i>
                    </span>
                    <span
                        v-if="purchase_proposal.balcony"
                        class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                        title="Balcone"
                    >
                        <i class="fa-solid fa-building"></i>
                    </span>
                </div>

                <div>
                    <a
                        :href="route('admin.purchase-proposals.index')"
                        class="tool-button bg-main-blue border-main-blue text-white"
                    >
                        Visualizza proposte d'acquisto
                    </a>
                    <a
                        :href="`/admin/purchase-proposals/${purchase_proposal.id}/edit`"
                        class="tool-button bg-warning border-warning text-white"
                        title="Modifica proposta d'acquisto"
                    >
                        <i class="fas fa-edit"></i>
                    </a>
                    <button
                        title="Cancella proposta d'acquisto"
                        class="tool-button text-white bg-danger border-danger"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="flex">
                <div class="w-[20%]">
                    <h2 class="text-xl font-bold mb-3">Info richiesta</h2>
                    <ul>
                        <li>
                            <strong>Città: </strong>{{ purchase_proposal.city }}
                        </li>
                        <li class="my-4">
                            <strong>Area: </strong>
                            {{ purchase_proposal.area }}
                        </li>
                        <li class="my-4">
                            <strong>Metri quadri da: </strong
                            >{{ purchase_proposal.mq_from }}
                        </li>
                        <li class="my-4">
                            <strong>Metri quadri a: </strong
                            >{{ purchase_proposal.mq_to }}
                        </li>
                        <li class="my-4">
                            <strong>Prezzo da: </strong
                            >{{ purchase_proposal.price_from }}€
                        </li>
                        <li class="my-4">
                            <strong>Prezzo a: </strong
                            >{{ purchase_proposal.price_to }}€
                        </li>
                        <li class="my-4">
                            <strong>Tipologia di vendita: </strong>
                            <span
                                :class="
                                    purchase_proposal.sale_type == 1
                                        ? 'bg-main-blue'
                                        : 'bg-[#002EF6]'
                                "
                                class="rounded-full px-3 py-2 text-white"
                                >{{
                                    purchase_proposal.sale_type == 1
                                        ? "Vendita"
                                        : "Affitto"
                                }}</span
                            >
                        </li>
                        <li class="my-4">
                            <strong>Tipologia di immobile: </strong>
                            <span
                                class="rounded-full bg-green-700 px-3 py-2 text-white"
                                >{{
                                    purchase_proposal.type
                                        .charAt(0)
                                        .toUpperCase() +
                                    purchase_proposal.type.slice(1)
                                }}</span
                            >
                        </li>
                        <li
                            class="my-4"
                            v-if="
                                (purchase_proposal, energetic_efficency != null)
                            "
                        >
                            <strong>Efficenza energetica</strong>
                            {{ purchase_proposal.energetic_efficency }}
                        </li>
                    </ul>
                </div>
                <div class="w-[80%] border-l-[1px] border-main-blue px-5">
                    <h2 class="text-xl font-bold mb-3">Immobili</h2>
                    <!-- {{ estates }} -->
                    <div class="flex border-b-2">
                        <div class="p-2 border-l-2 border-r-2 w-[7%]">
                            <strong>Area</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[6%]">
                            <strong>Mq</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[9%]">
                            <strong>Prezzo</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[10%]">
                            <strong>Tipologia<br />Vendita</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[16%]">
                            <strong>Tipologia<br />Immobile</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[8%]">
                            <strong>Classe<br />Energetica</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[7%]">
                            <strong>Numero<br />Stanze</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[7%]">
                            <strong>Numero<br />Bagni</strong>
                        </div>
                        <div class="pt-2 pl-1 border-l-2 border-r-2 w-[7%]">
                            <strong>Giardino</strong>
                        </div>
                        <div class="pt-2 pl-1 border-l-2 border-r-2 w-[7%]">
                            <strong>Balcone</strong>
                        </div>
                        <div class="pt-2 pl-1 border-l-2 border-r-2 w-[8%]">
                            <strong>Posto<br />Auto</strong>
                        </div>
                        <div class="pt-2 pl-1 border-l-2 border-r-2 w-[8%]">
                            <strong>Ascensore</strong>
                        </div>
                    </div>
                    <div class="flex border-b-2" v-for="estate in estates">
                        <div
                            :class="
                                estate.area_id == purchase_proposal.area_id
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[7%]"
                        >
                            {{ estate.area }}
                        </div>
                        <div
                            :class="
                                estate.mq >= purchase_proposal.mq_from &&
                                estate.mq <= purchase_proposal.mq_to
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[6%]"
                        >
                            {{ estate.mq }}
                        </div>
                        <div
                            :class="
                                estate.price >= purchase_proposal.price_from &&
                                estate.price <= purchase_proposal.price_to
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[9%]"
                        >
                            {{ estate.price }}€
                        </div>
                        <div
                            :class="
                                estate.sale_type == purchase_proposal.sale_type
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[10%]"
                        >
                            {{ estate.sale_type == 1 ? "Vendita" : "Affitto" }}
                        </div>
                        <div
                            :class="
                                estate.type == purchase_proposal.type
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[16%]"
                        >
                            {{
                                estate.type.charAt(0).toUpperCase() +
                                estate.type.slice(1)
                            }}
                        </div>
                        <div
                            :class="
                                estate.energetic_efficency ==
                                purchase_proposal.energetic_efficency
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[8%]"
                        >
                            {{ estate.energetic_efficency }}
                        </div>
                        <div
                            :class="
                                estate.number_rooms ==
                                purchase_proposal.number_rooms
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[7%]"
                        >
                            {{ estate.number_rooms }}
                        </div>
                        <div
                            :class="
                                estate.number_bathrooms ==
                                purchase_proposal.number_bathrooms
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[7%]"
                        >
                            {{ estate.number_bathrooms }}
                        </div>
                        <div
                            :class="
                                estate.garden == purchase_proposal.garden &&
                                estate.garden == 1 &&
                                purchase_proposal.garden == 1
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[7%]"
                        >
                            {{ estate.garden == 1 ? "Sì" : "No" }}
                        </div>
                        <div
                            :class="
                                estate.balcony == purchase_proposal.balcony &&
                                estate.balcony == 1 &&
                                purchase_proposal.balcony == 1
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[7%]"
                        >
                            {{ estate.balcony == 1 ? "Sì" : "No" }}
                        </div>
                        <div
                            :class="
                                estate.parking_space ==
                                    purchase_proposal.parking_space &&
                                estate.parking_space == 1 &&
                                purchase_proposal.parking_space == 1
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[8%]"
                        >
                            {{ estate.parking_space == 1 ? "Sì" : "No" }}
                        </div>
                        <div
                            :class="
                                estate.elevator == purchase_proposal.elevator &&
                                estate.elevator == 1 &&
                                purchase_proposal.elevator == 1
                                    ? 'bg-main-blue text-white'
                                    : ''
                            "
                            class="p-2 border-l-2 border-r-2 w-[8%]"
                        >
                            {{ estate.elevator == 1 ? "Sì" : "No" }}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="my-5">
                    <h4>Note</h4>
                    <hr />
                </div>
                <div>{{ purchase_proposal.notes }}</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
