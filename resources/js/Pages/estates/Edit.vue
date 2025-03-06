<script setup>
import { ref, onMounted } from "vue";

import axios from "axios";

import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import FileInput from "../../Components/FileInput.vue";

const props = defineProps({
    errors: Object,
    areas: Array,
    customers: Array,
    estate: Object,
});

let area = ref("");
let file = ref([]);

const $toast = useToast();

const form = useForm({
    name: props.estate.estateName,
    address: props.estate.address,
    city: props.estate.city,
    mq: props.estate.mq,
    price: props.estate.price,
    type: props.estate.type,
    customer_id: props.estate.customer_id,
    area_id: props.estate.area_id,
    sale_type: props.estate.sale_type,
    number_bathrooms: props.estate.number_bathrooms,
    number_rooms: props.estate.number_rooms,
    elevator: props.estate.elevator,
    garden: props.estate.garden,
    balcony: props.estate.balcony,
    parking_space: props.estate.parking_space,
    energetic_efficency:
        props.estate.energetic_efficency == null
            ? ""
            : props.estate.energetic_efficency,
    description: props.estate.description,
    cover_image: props.estate.cover_image,
    gallery: props.estate.galleryImages,
});

onMounted(() => {
    if (typeof form.gallery === "string" && form.gallery.length > 0) {
        form.gallery = form.gallery.split(",");
    } else {
        form.gallery = [];
    }
});

const form_customer = useForm({
    name: "",
    surname: "",
    email: "",
    phone: "",
    address: "",
});

const update = () => {
    if (form.customer_id == "new") {
        axios
            .post(route("admin.api.customers.store", form_customer))
            .then((response) => {
                form.customer_id = response.data.results;

                form.transform((data) => {
                    let formData = new FormData();
                    Object.keys(data).forEach((key) => {
                        if (data[key] !== null && data[key] !== undefined) {
                            formData.append(key, data[key]);
                        }
                    });

                    let existingImages = [];

                    data.gallery.forEach((image) => {
                        if (typeof image === "string") {
                            existingImages.push(image); // 🔥 Mantiene immagini esistenti come stringhe
                        } else {
                            formData.append(`new_gallery[]`, image); // 🔥 Aggiunge nuove immagini come File
                        }
                    });

                    formData.append(
                        "existing_gallery",
                        existingImages.join(",")
                    );

                    formData.append("_method", "PUT");
                    return formData;
                }).post(
                    route("admin.estates.update", { estate: props.estate.id }),
                    {
                        onSuccess: (resp) => {
                            $toast.success("Immobile modificato", {
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
                    }
                );
            });
    } else {
        form.transform((data) => {
            let formData = new FormData();
            Object.keys(data).forEach((key) => {
                if (data[key] !== null && data[key] !== undefined) {
                    formData.append(key, data[key]);
                }
            });

            let existingImages = [];
            data.gallery.forEach((image) => {
                if (typeof image === "string") {
                    existingImages.push(image); // 🔥 Mantiene immagini esistenti come stringhe
                } else {
                    formData.append(`new_gallery[]`, image); // 🔥 Aggiunge nuove immagini come File
                }
            });

            formData.append("existing_gallery", existingImages.join(","));

            formData.append("_method", "PUT");
            return formData;
        }).post(route("admin.estates.update", { estate: props.estate.id }), {
            onSuccess: (resp) => {
                $toast.success("Immobile modificato", {
                    position: "top-right",
                    duration: 3000,
                });
            },
            onError: (resp) => {
                console.log(form);
                console.log(resp);
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

const setFormImage = (file) => {
    form.cover_image = file[0];
};

const setGalleryImages = (files) => {
    console.log(files);
    console.log(form.gallery);
    for (let i = 0; i < files.length; i++) {
        form.gallery.push(files[i]);
    }
    console.log(form.gallery);
};
</script>
<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-3xl">Aggiungi Immobile</h2>
            <a
                :href="route('admin.estates.index')"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Visualizza immobili
            </a>
        </div>
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
                <label class="label-text">Cliente</label>
                <select
                    v-model="form.customer_id"
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
            <div>
                <label class="label-text">Immagine copertina</label>
                <FileInput
                    :multiple="false"
                    @loadImage="setFormImage"
                    :default="form.cover_image"
                />
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
                        class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                        class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                        class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                        class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                        class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
            <h4>Galleria immagini</h4>
            <hr />
        </div>
        <div class="grid grid-cols-1 gap-5">
            <div>
                <label class="label-text">Immagini</label>
                <FileInput
                    :multiple="true"
                    @loadImage="setGalleryImages"
                    :default="form.gallery"
                />
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
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                <label class="label-text">Indirizzo</label>
                <input
                    type="text"
                    placeholder="Indirizzo"
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.address"
                />
                <div v-if="form.errors.address" class="text-danger">
                    {{ form.errors.address }}
                </div>
            </div>
            <div>
                <label class="label-text">Città</label>
                <input
                    type="text"
                    placeholder="Città"
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                <label class="label-text">Prezzo</label>
                <input
                    min="0"
                    type="number"
                    placeholder="Prezzo"
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.price"
                />
                <div v-if="form.errors.price" class="text-danger">
                    {{ form.errors.price }}
                </div>
            </div>
        </div>
        <div class="my-5">
            <h4>Caratteristiche immobile</h4>
            <hr />
        </div>
        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="label-text">Metri quadri</label>
                <input
                    type="number"
                    placeholder="Metri quadri"
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.mq"
                />
                <div v-if="form.errors.mq" class="text-danger">
                    {{ form.errors.mq }}
                </div>
            </div>
            <div>
                <label class="label-text">Numero stanze</label>
                <input
                    type="number"
                    placeholder="Numero stanze"
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
                    class="text-xs border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    :checked="form.elevator"
                />
            </div>
            <div>
                <label class="label-text me-5">Giardino</label>
                <input
                    type="checkbox"
                    class="text-xs border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    :checked="form.garden"
                />
            </div>
            <div>
                <label class="label-text me-5">Parcheggio/Posto auto</label>
                <input
                    type="checkbox"
                    class="text-xs border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    :checked="form.parking_space"
                />
            </div>
            <div>
                <label class="label-text me-5">Balcone/Terrazzo</label>
                <input
                    type="checkbox"
                    class="text-xs border-gray-300 focus:border-main-blue focus:ring-main-blue"
                    :checked="form.balcony"
                />
            </div>
            <div>
                <label class="label-text me-5">Efficenza Energetica</label>
                <select
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
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
        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="label-text">Descrizione</label>
                <textarea
                    class="text-xs rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                    v-model="form.description"
                    placeholder="Descrizione"
                ></textarea>
            </div>
        </div>
        <div class="nuova-form">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-10 mt-10">
                    <button
                        @click="update"
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
