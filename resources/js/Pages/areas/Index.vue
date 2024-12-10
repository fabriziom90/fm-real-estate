<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

defineProps({
    areas: Array,
});
</script>

<template lang="">
    <AuthenticatedLayout>
        <h2 class="text-3xl">Elenco aree</h2>
        <table class="table-auto">
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
                        <a href="#" class=""></a>
                    </td>
                </tr>
            </tbody>
            <li v-for="area in areas">{{ area.area }}</li>
        </table>
    </AuthenticatedLayout>
</template>
<style lang=""></style>
