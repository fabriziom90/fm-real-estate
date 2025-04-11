<script setup>
import { ref, onMounted } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Carousel from "../../Components/Carousel.vue";

const estates = ref([]);

const props = defineProps({
    purchase_proposal: Object,
    estates: Array,
});

onMounted(() => {
    const estatesProp = props.estates;

    const estatesWithPercentage = estatesProp.map((estate) => {
        let sumPercentage = 0;

        if (
            estate.mq >= props.purchase_proposal.mq_from &&
            estate.mq <= props.purchase_proposal.mq_to
        ) {
            sumPercentage += 20;
        }

        if (
            estate.price >= props.purchase_proposal.price_from &&
            estate.price <= props.purchase_proposal.price_to
        ) {
            sumPercentage += 20;
        }

        if (estate.sale_type == props.purchase_proposal.sale_type) {
            sumPercentage += 5;
        }

        if (estate.area_id == props.purchase_proposal.area_id) {
            sumPercentage += 15;
        }

        if (
            estate.energetic_efficency ==
            props.purchase_proposal.energetic_efficency
        ) {
            sumPercentage += 5;
        }

        if (estate.number_rooms == props.purchase_proposal.number_rooms) {
            sumPercentage += 5;
        }

        if (
            estate.number_bathrooms == props.purchase_proposal.number_bathrooms
        ) {
            sumPercentage += 5;
        }

        if (
            estate.garden == props.purchase_proposal.garden &&
            estate.garden == 1 &&
            props.purchase_proposal.garden == 1
        ) {
            sumPercentage += 5;
        }

        if (
            estate.parking_space == props.purchase_proposal.parking_space &&
            estate.parking_space == 1 &&
            props.purchase_proposal.parking_space == 1
        ) {
            sumPercentage += 5;
        }

        if (
            estate.elevator == props.purchase_proposal.elevator &&
            estate.elevator == 1 &&
            props.purchase_proposal.elevator == 1
        ) {
            sumPercentage += 5;
        }

        if (
            estate.balcony == props.purchase_proposal.balcony &&
            estate.balcony == 1 &&
            props.purchase_proposal.balcony == 1
        ) {
            sumPercentage += 5;
        }

        if (
            estate.number_bathrooms == props.purchase_proposal.number_bathrooms
        ) {
            sumPercentage += 5;
        }

        return { ...estate, percentage: sumPercentage };
    });

    estates.value = estatesWithPercentage.sort((a, b) => {
        return b.percentage - a.percentage;
    });
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
            <div>
                <div class="flex flex-wrap">
                    <div class="w-[60%]">
                        <h2 class="text-xl font-bold mb-3">Info richiesta</h2>
                        <ul class="flex flex-wrap">
                            <li class="my-4 w-[250px]">
                                <strong>Città: </strong
                                >{{ purchase_proposal.city }}
                            </li>
                            <li class="my-4 w-[250px]">
                                <strong>Area: </strong>
                                {{ purchase_proposal.area }}
                            </li>
                            <li class="my-4 w-[250px]">
                                <strong>Metri quadri da: </strong
                                >{{ purchase_proposal.mq_from }}
                            </li>
                            <li class="my-4 w-[250px]">
                                <strong>Metri quadri a: </strong
                                >{{ purchase_proposal.mq_to }}
                            </li>
                            <li class="my-4 w-[250px]">
                                <strong>Prezzo da: </strong
                                >{{ purchase_proposal.price_from }}€
                            </li>
                            <li class="my-4 w-[250px]">
                                <strong>Prezzo a: </strong
                                >{{ purchase_proposal.price_to }}€
                            </li>
                            <li class="my-4 w-[250px]">
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
                            <li class="my-4 w-[250px]">
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
                                class="my-4 w-[20%]"
                                v-if="
                                    (purchase_proposal,
                                    energetic_efficency != null)
                                "
                            >
                                <strong>Efficenza energetica</strong>
                                {{ purchase_proposal.energetic_efficency }}
                            </li>
                        </ul>
                    </div>
                    <div class="w-[40%] pl-2 border-l-2 border-main-blue">
                        <h4><strong>Note</strong></h4>
                        <div>{{ purchase_proposal.notes }}</div>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t-2 border-main-blue">
                    <h2 class="text-xl font-bold mb-3">Immobili</h2>
                    <!-- {{ estates }} -->
                    <div class="flex border-b-2">
                        <div class="p-2 border-l-2 border-r-2 w-[10%]">
                            <strong>% compatibilità</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[7%]">
                            <strong>Area</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[6%]">
                            <strong>Mq</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[7%]">
                            <strong>Prezzo</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[10%]">
                            <strong>Tipologia<br />Vendita</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[11%]">
                            <strong>Tipologia<br />Immobile</strong>
                        </div>
                        <div class="p-2 border-l-2 border-r-2 w-[7%]">
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
                        <div class="pt-2 pl-1 border-l-2 border-r-2 w-[7%]">
                            <strong>Posto<br />Auto</strong>
                        </div>
                        <div class="pt-2 pl-1 border-l-2 border-r-2 w-[7%]">
                            <strong>Ascensore</strong>
                        </div>
                    </div>
                    <div class="flex border-b-2" v-for="estate in estates">
                        <div class="p-2 border-l-2 border-r-2 w-[10%]">
                            <div class="progress-bar position-relative">
                                <div
                                    class="progress-bar-container text-white text-center"
                                    :style="`width:${estate.percentage}%`"
                                >
                                    <div class="position-absolute">
                                        {{ estate.percentage }}%
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            class="p-2 border-l-2 border-r-2 w-[7%]"
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
                            class="p-2 border-l-2 border-r-2 w-[11%]"
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
                            class="p-2 border-l-2 border-r-2 w-[7%]"
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
                            class="p-2 border-l-2 border-r-2 w-[7%]"
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
                            class="p-2 border-l-2 border-r-2 w-[7%]"
                        >
                            {{ estate.elevator == 1 ? "Sì" : "No" }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.progress-bar {
    background-color: #011a9078;
    border-radius: 20px;
    height: 25px;
}

.progress-bar-container {
    background-color: #011a90;
    border-radius: 20px;
    height: 25px;
}

.position-relative {
    position: relative;
}

.position-absolute {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}
</style>
