<script setup>
import { ref } from "vue";

const props = defineProps({ multiple: Boolean });

const file = ref("");
const fileInput = ref(null);
const previews = ref([]);

const emit = defineEmits(["loadImage"]);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    files.forEach((file) => {
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (!props.multiple) {
                    previews.value = [];
                }

                previews.value.push(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    emit("loadImage", files);
};
</script>
<template lang="">
    <div class="dropzone" @click="triggerFileInput">
        <p>Clicca quì per caricare il file</p>
        <input
            type="file"
            ref="fileInput"
            accept="image/*"
            hidden
            @change="handleFileChange"
        />
        <div v-if="previews.length > 0">
            <div
                v-for="(preview, index) in previews"
                :key="index"
                class="preview"
            >
                <img :src="preview" alt="Anteprima immagine" />
            </div>
        </div>
    </div>
</template>
<style lang=""></style>
