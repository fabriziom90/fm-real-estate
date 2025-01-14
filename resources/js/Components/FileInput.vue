<script setup>
import { ref } from "vue";

const props = defineProps({ multiple: Boolean });

const files = ref("");
const fileInput = ref(null);
const previews = ref([]);

const emit = defineEmits(["loadImage"]);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleFileChange = (event) => {
    files.value = Array.from(event.target.files);
    files.value.forEach((file) => {
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

    emit("loadImage", files.value);
};

const removeImage = (index) => {
    event.stopPropagation();
    files.value.splice(index, 1);
    previews.value.splice(index, 1);
};
</script>
<template lang="">
    <div class="file-container" @click="triggerFileInput">
        <p>Clicca quì per caricare il file</p>
        <input
            type="file"
            ref="fileInput"
            accept="image/*"
            hidden
            :multiple="props.multiple"
            @change="handleFileChange"
        />
        <div class="preview-container" v-if="previews.length > 0">
            <div
                v-for="(preview, index) in previews"
                :key="index"
                class="preview"
            >
                <img :src="preview" alt="Anteprima immagine" />
                <span class="delete-img" @click="removeImage(index)">x</span>
            </div>
        </div>
    </div>
</template>
<style>
.file-container {
    border: 2px dashed #cccccc;
    padding: 20px;
    text-align: center;
    cursor: pointer;
}
.file-container:hover {
    background-color: #f9f9f9;
}
.preview-container {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}
.preview {
    margin: 10px;
    width: 100px;
    height: 100px;
    /* overflow: hidden; */
    border: 1px solid #ddd;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}
.preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.delete-img {
    position: absolute;
    top: -20px;
    background-color: #011a90;
    cursor: pointer;
    right: -20px;
    z-index: 100;
    border-radius: 50%;
    border: 5px solid #fff;
    color: #fff;
    padding: 5px 12px;
    transition: 0.3s;
}

.delete-img:hover {
    background-color: #0020b2;
}
</style>
