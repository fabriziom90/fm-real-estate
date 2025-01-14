<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    estate: Object,
});

const baseUrl = ref(window.location.origin);
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between mb-10">
            <div>
                <h2 class="text-3xl">Immobile: {{ estate.name }}</h2>
            </div>

            <div>
                <a
                    :href="route('admin.estates.index')"
                    class="tool-button bg-main-blue border-main-blue text-white"
                >
                    Visualizza immobili
                </a>
                <button
                    title="Cancella immobile"
                    class="tool-button text-white bg-danger border-danger"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="flex">
            <div>
                <img
                    :src="
                        estate.cover_image != null
                            ? `${baseUrl}/storage/${estate.cover_image}`
                            : `https://placehold.co/400x400`
                    "
                />
            </div>
            <div class="carousel">
                <VueSlickCarousel :arrows="true" :dots="true">
                    <div>1</div>
                    <div>2</div>
                    <div>3</div>
                    <div>4</div>
                </VueSlickCarousel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
