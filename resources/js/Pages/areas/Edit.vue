<script setup>
import { ref } from "vue";

import axios from "axios";

import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({ area: Object, errors: Object });

const $toast = useToast();

const form = useForm({
    area: props.area.area,
});

const store = () => {
    form.put(route("admin.areas.update", { area: props.area.id }), {
        onSuccess: (resp) => {
            $toast.success("Area aggiornata correttamente", {
                position: "top-right",
                duration: 3000,
            });
        },
        onError: (resp) => {
            $toast.error(
                "Inserimento non completato. Verifica i campi della form.",
                {
                    position: "top-right",
                    duration: 3000,
                }
            );
        },
    });
};
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl mb-10">Modifica area</h2>
            <a
                :href="route('admin.areas.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza aree
            </a>
        </div>
        <div class="nuova-form">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-3">
                    <div>
                        <label class="label-text">Nome area</label>
                        <input
                            type="text"
                            placeholder="Nome area"
                            class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                            v-model="form.area"
                        />
                        <div v-if="form.errors.area" class="text-danger">
                            {{ form.errors.area }}
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-10 mt-10">
                    <button
                        @click="store"
                        :disabled="form.processing"
                        class="tool-button bg-main-blue border-main-blue text-white m-0"
                    >
                        {{ form.processing ? "Salvataggio in corso" : "Salva" }}
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
