<script setup>
import { ref } from "vue";

import axios from "axios";

import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({ customer: Object, errors: Object });

let area = ref("");

const $toast = useToast();

const form = useForm({
    name: props.customer.name,
    surname: props.customer.surname,
    email: props.customer.email,
    phone: props.customer.phone,
    address: props.customer.address,
});

const store = () => {
    form.put(route("admin.customers.update", { customer: props.customer.id }), {
        onSuccess: (resp) => {
            $toast.success("Cliente inserito", {
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
            <h2 class="text-3xl">Modifica Cliente</h2>
            <a
                :href="route('admin.areas.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza clienti
            </a>
        </div>
        <div class="nuova-form">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-3 gap-5">
                    <div>
                        <label class="label-text">Nome</label>
                        <input
                            type="text"
                            placeholder="Nome"
                            class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                            v-model="form.name"
                        />
                        <div v-if="form.errors.name" class="text-danger">
                            {{ form.errors.name }}
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Cognome</label>
                        <input
                            type="text"
                            placeholder="Nome"
                            class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                            v-model="form.surname"
                        />
                        <div v-if="form.errors.surname" class="text-danger">
                            {{ form.errors.surname }}
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Email</label>
                        <input
                            type="text"
                            placeholder="Nome"
                            class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                            v-model="form.email"
                        />
                        <div v-if="form.errors.email" class="text-danger">
                            {{ form.errors.email }}
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Telefono</label>
                        <input
                            type="text"
                            placeholder="Nome"
                            class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                            v-model="form.phone"
                        />
                        <div v-if="form.errors.phone" class="text-danger">
                            {{ form.errors.phone }}
                        </div>
                    </div>
                    <div>
                        <label class="label-text">Indirizzo</label>
                        <input
                            type="text"
                            placeholder="Nome"
                            class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                            v-model="form.address"
                        />
                        <div v-if="form.errors.address" class="text-danger">
                            {{ form.errors.address }}
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
