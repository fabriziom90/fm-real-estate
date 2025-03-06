<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import Carousel from "../../Components/Carousel.vue";

const props = defineProps({
    estate: Object,
});

const baseUrl = ref(window.location.origin);
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between mb-10">
            <div>
                <h2 class="text-3xl mb-3">
                    Immobile: {{ estate.estateName }} - {{ estate.price }}€
                </h2>
                <span
                    v-if="estate.elevator"
                    class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                    title="Ascensore"
                >
                    <i class="fa-solid fa-elevator"></i>
                </span>
                <span
                    v-if="estate.garden"
                    class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                    title="Giardino"
                >
                    <i class="fa-solid fa-tree"></i>
                </span>
                <span
                    v-if="estate.parking_space"
                    class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                    title="Parcheggio/Posto auto"
                >
                    <i class="fa-solid fa-square-parking"></i>
                </span>
                <span
                    v-if="estate.balcony"
                    class="bg-main-blue rounded-full px-5 py-2 mr-2 text-white"
                    title="Balcone"
                >
                    <i class="fa-solid fa-building"></i>
                </span>
            </div>

            <div>
                <a
                    :href="route('admin.estates.index')"
                    class="tool-button bg-main-blue border-main-blue text-white"
                >
                    Visualizza immobili
                </a>
                <a
                    :href="`/admin/estates/${estate.id}/edit`"
                    class="tool-button bg-warning border-warning text-white"
                    title="Modifica immobile"
                >
                    <i class="fas fa-edit"></i>
                </a>
                <button
                    title="Cancella immobile"
                    class="tool-button text-white bg-danger border-danger"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-5">
            <div>
                <div class="cover-image">
                    <img
                        :src="
                            estate.cover_image != null
                                ? `${baseUrl}/storage/${estate.cover_image}`
                                : `https://placehold.co/400x400`
                        "
                    />
                </div>
                <div v-if="estate.galleryImages != null">
                    <div class="my-5">
                        <h4>Galleria immagini</h4>
                        <hr />
                    </div>
                    <div>
                        <Carousel :gallery="estate.galleryImages" />
                    </div>
                </div>
            </div>
            <div class="border-l-[1px] border-main-blue px-5">
                <ul>
                    <li>
                        <strong>Indirizzo: </strong>{{ estate.address }} -
                        {{ estate.city }}
                    </li>
                    <li class="my-4">
                        <strong>Area: </strong>
                        {{ estate.area }}
                    </li>
                    <li class="my-4">
                        <strong>Metri quadri:</strong>{{ estate.mq }}
                    </li>
                    <li class="my-4">
                        <strong>Tipologia di vendita: </strong>
                        <span
                            :class="
                                estate.sale_type == 1
                                    ? 'bg-main-blue'
                                    : 'bg-[#002EF6]'
                            "
                            class="rounded-full px-3 py-2 text-white"
                            >{{
                                estate.sale_type == 1 ? "Vendita" : "Affitto"
                            }}</span
                        >
                    </li>
                    <li class="my-4">
                        <strong>Tipologia di immobile: </strong>
                        <span
                            class="rounded-full bg-green-700 px-3 py-2 text-white"
                            >{{
                                estate.type.charAt(0).toUpperCase() +
                                estate.type.slice(1)
                            }}</span
                        >
                    </li>
                    <li
                        class="my-4"
                        v-if="(estate, energetic_efficency != null)"
                    >
                        <strong>Efficenza energetica</strong>
                        {{ estate.energetic_efficency }}
                    </li>
                </ul>
                <div class="my-5">
                    <h4>Descrizione</h4>
                    <hr />
                </div>
                <div>{{ estate.description }}</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.mx-3 {
    margin: 0px 0.75rem;
}

.cover-image img {
    max-width: 500px;
    width: 100%;
    height: 400px;
    object-fit: cover;
}
</style>
