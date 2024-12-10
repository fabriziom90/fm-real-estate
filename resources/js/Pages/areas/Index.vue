<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

defineProps({
    areas: Array,
});
</script>

<template lang="">
    <AuthenticatedLayout>
        <div class="flex justify-between items-center">
            <h2 class="text-3xl mb-10">Elenco aree</h2>
            <a
                href="#"
                class="tool-button bg-main-blue border-main-blue text-white"
            >
                Aggiungi area
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Area</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="area in areas">
                        <td>{{ area.id }}</td>
                        <td>{{ area.area }}</td>
                        <td>
                            <a
                                href="#"
                                class="tool-button text-white bg-main-blue border-main-blue"
                            >
                                <i class="fas fa-eye"></i>
                            </a>
                            <a
                                href="#"
                                class="tool-button text-white bg-warning border-warning"
                            >
                                <i class="fas fa-edit"></i>
                            </a>
                            <a
                                href="#"
                                class="tool-button text-white bg-danger border-danger"
                            >
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <li v-for="area in areas">{{ area.area }}</li>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
