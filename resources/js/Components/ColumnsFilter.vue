<script setup>
import { ref, onMounted, computed } from "vue";

const emit = defineEmits(["showColumn"]);
const props = defineProps({
    columns: Array,
});
</script>
<template lang="">
    <div class="mb-3 border-b-2 border-main-blue">
        <div>
            <h3><strong>Filtri:</strong></h3>
        </div>
        <div class="flex flex-wrap">
            <div
                class="my-5 w-[calc(100%/3)] md:w-[calc(100%/4)] xl:w-[calc(100%/6)]"
                v-for="column in columns"
            >
                <div
                    class="flex items-center"
                    v-if="column.columnName != 'tools'"
                >
                    <span class="me-3"> {{ column.label }}: </span>
                    <label class="switch">
                        <input
                            type="checkbox"
                            @change="emit('showColumn', column.columnName)"
                            :checked="column.show"
                        />
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.preview-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
}

.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 15px;
    width: 15px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #011a90;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196f3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(18px);
    -ms-transform: translateX(18px);
    transform: translateX(18px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
