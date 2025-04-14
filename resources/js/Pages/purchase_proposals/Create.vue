<script setup>
import { ref } from "vue";

import axios from "axios";

import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import FileInput from "../../Components/FileInput.vue";

defineProps({ errors: Object, areas: Array, customers: Array });

let area = ref("");
let file = ref([]);

const $toast = useToast();

const form = useForm({
    area_id: "",
    customer_id: "",
    address: "",
    city: "",
    sale_type: "",
    mq_from: "",
    mq_to: "",
    price_from: "",
    price_to: "",
    type: "",
    number_rooms: "",
    number_bathrooms: "",
    elevator: "",
    garden: "",
    parking_space: "",
    balcony: "",
    energetic_efficency: "",
    notes: "",
});

const form_customer = useForm({
    name: "",
    surname: "",
    email: "",
    phone: "",
    address: "",
});

const store = () => {
    if (form.customer_id == "new") {
        axios
            .post(route("admin.api.customers.store", form_customer))
            .then((response) => {
                form.customer_id = response.data.results;

                form.post(route("admin.purchase-proposals.store"), {
                    onSuccess: (resp) => {
                        $toast.success("Immobile inserito", {
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
            });
    } else {
        form.post(route("admin.purchase-proposals.store"), {
            onSuccess: (resp) => {
                $toast.success("Proposta d'acquisto inserita correttamente", {
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
    }
};
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl">Aggiungi proposta d'acquisto</h2>
            <a
                :href="route('admin.estates.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza proposte d'acquisto
            </a>
        </div>
        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="label-text">Cliente</label>
                <select
                    v-model="form.customer_id"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    required
                >
                    <option value="">Seleziona cliente</option>
                    <option
                        v-for="customer in customers"
                        :key="customer.id"
                        :value="customer.id"
                    >
                        {{ customer.name }} {{ customer.surname }}
                    </option>
                    <option value="new">Inserisci nuovo cliente</option>
                </select>
            </div>
        </div>
        <div v-if="form.customer_id == 'new'">
            <div class="my-5">
                <h4>Inserisci nuovo cliente</h4>
                <hr />
            </div>
            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="label-text">Nome</label>
                    <input
                        type="text"
                        placeholder="Nome"
                        class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form_customer.name"
                    />
                    <div v-if="form_customer.errors.name" class="text-danger">
                        {{ form_customer.errors.name }}
                    </div>
                </div>
                <div>
                    <label class="label-text">Cognome</label>
                    <input
                        type="text"
                        placeholder="Nome"
                        class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form_customer.surname"
                    />
                    <div
                        v-if="form_customer.errors.surname"
                        class="text-danger"
                    >
                        {{ form_customer.errors.surname }}
                    </div>
                </div>
                <div>
                    <label class="label-text">Email</label>
                    <input
                        type="text"
                        placeholder="Nome"
                        class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form_customer.email"
                    />
                    <div v-if="form_customer.errors.email" class="text-danger">
                        {{ form_customer.errors.email }}
                    </div>
                </div>
                <div>
                    <label class="label-text">Telefono</label>
                    <input
                        type="text"
                        placeholder="Nome"
                        class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form_customer.phone"
                    />
                    <div v-if="form_customer.errors.phone" class="text-danger">
                        {{ form_customer.errors.phone }}
                    </div>
                </div>
                <div>
                    <label class="label-text">Indirizzo</label>
                    <input
                        type="text"
                        placeholder="Nome"
                        class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form_customer.address"
                    />
                    <div
                        v-if="form_customer.errors.address"
                        class="text-danger"
                    >
                        {{ form_customer.errors.address }}
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5">
            <h4>Località immobile</h4>
            <hr />
        </div>
        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="label-text">Area</label>
                <select
                    v-model="form.area_id"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    required
                >
                    <option value="">Seleziona area</option>
                    <option
                        v-for="area in areas"
                        :key="area.id"
                        :value="area.id"
                    >
                        {{ area.area }}
                    </option>
                </select>
                <div v-if="form.errors.name" class="text-danger">
                    {{ form.errors.name }}
                </div>
            </div>
            <div>
                <label class="label-text">Città</label>
                <input
                    type="text"
                    placeholder="Città"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.city"
                />
                <div v-if="form.errors.city" class="text-danger">
                    {{ form.errors.city }}
                </div>
            </div>
            <div>
                <label class="label-text">Tipologia</label>
                <select
                    v-model="form.type"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                >
                    <option value="">Seleziona tipologia</option>
                    <option value="appartamento">Appartmento</option>
                    <option value="villa">Villa</option>
                    <option value="villino">Villino a schiera</option>
                    <option value="loft">Loft</option>
                </select>

                <div v-if="form.errors.type" class="text-danger">
                    {{ form.errors.type }}
                </div>
            </div>
        </div>
        <div class="my-5">
            <h4>Informazioni di vendita</h4>
            <hr />
        </div>
        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="label-text">Tipologia di vendita</label>
                <select
                    v-model="form.sale_type"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                >
                    <option value="">Seleziona tipologia</option>
                    <option value="1">Vendita</option>
                    <option value="2">Affitto</option>
                </select>

                <div v-if="form.errors.sale_type" class="text-danger">
                    {{ form.errors.sale_type }}
                </div>
            </div>
            <div>
                <label class="label-text">Prezzo Da</label>
                <input
                    min="0"
                    type="number"
                    placeholder="Prezzo"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.price_from"
                />
                <div v-if="form.errors.price_from" class="text-danger">
                    {{ form.errors.price_from }}
                </div>
            </div>
            <div>
                <label class="label-text">Prezzo A</label>
                <input
                    min="0"
                    type="number"
                    placeholder="Prezzo"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.price_to"
                />
                <div v-if="form.errors.price_to" class="text-danger">
                    {{ form.errors.price_to }}
                </div>
            </div>
        </div>
        <div class="my-5">
            <h4>Caratteristiche immobile</h4>
            <hr />
        </div>
        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="label-text">Metri quadri Da</label>
                <input
                    type="number"
                    placeholder="Metri quadri"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.mq_from"
                />
                <div v-if="form.errors.mq_from" class="text-danger">
                    {{ form.errors.mq_from }}
                </div>
            </div>
            <div>
                <label class="label-text">Metri quadri A</label>
                <input
                    type="number"
                    placeholder="Metri quadri"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.mq_to"
                />
                <div v-if="form.errors.mq_to" class="text-danger">
                    {{ form.errors.mq_to }}
                </div>
            </div>
            <div>
                <label class="label-text">Numero stanze</label>
                <input
                    type="number"
                    placeholder="Numero stanze"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.number_rooms"
                    min="0"
                />
                <div v-if="form.errors.number_rooms" class="text-danger">
                    {{ form.errors.number_rooms }}
                </div>
            </div>
            <div>
                <label class="label-text">Numero bagni</label>
                <input
                    type="number"
                    placeholder="Numero bagni"
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.number_bathrooms"
                    min="0"
                />
                <div v-if="form.errors.number_bathrooms" class="text-danger">
                    {{ form.errors.number_bathrooms }}
                </div>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-5 my-5">
            <div>
                <label class="label-text me-5">Ascensore</label>
                <input
                    type="checkbox"
                    class="text-lg border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    v-model="form.elevator"
                />
            </div>
            <div>
                <label class="label-text me-5">Giardino</label>
                <input
                    type="checkbox"
                    class="text-lg border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    v-model="form.garden"
                />
            </div>
            <div>
                <label class="label-text me-5">Parcheggio/Posto auto</label>
                <input
                    type="checkbox"
                    class="text-lg border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    v-model="form.parking_space"
                />
            </div>
            <div>
                <label class="label-text me-5">Balcone/Terrazzo</label>
                <input
                    type="checkbox"
                    class="text-lg border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    v-model="form.balcony"
                />
            </div>
            <div>
                <label class="label-text me-5">Efficenza Energetica</label>
                <select
                    class="text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.energetic_efficency"
                >
                    <option value="">Seleziona l'efficenza energetica</option>

                    <option value="A+++">A+++</option>
                    <option value="A++">A++</option>
                    <option value="A+">A+</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
            </div>
        </div>
        <div>
            <label class="label-text me-5">Note</label>
            <textarea
                rows="10"
                class="w-100 text-lg rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                v-model="form.notes"
            ></textarea>
        </div>
        <div class="nuova-form">
            <form @submit.prevent="submit">
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
