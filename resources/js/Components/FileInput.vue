<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useToast } from "vue-toast-notification";

const $toast = useToast();

const props = defineProps({ multiple: Boolean, default: String });

const files = ref("");
const fileInput = ref(null);
const previews = ref([]);
const baseUrl = ref(window.location.origin);

const emit = defineEmits(["loadImage"]);

const triggerFileInput = () => {
    fileInput.value.click();
};

onMounted(() => {
    if (!props.multiple) {
        if (props.default != null) {
            previews.value = [`${baseUrl.value}/storage/${props.default}`];
        }
    } else {
        if (props.default != null) {
            const images = props.default.split(",");
            const fullPathImages = images.map(
                (str) => `${baseUrl.value}/storage/${str}`
            );
            previews.value = fullPathImages;
        }
    }
});

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
    if (props.multiple) {
        // if files variable has length more than zero, remove the element from files array and previews array
        if (files.length > 0) {
            console.log(files);
            files.value.splice(index, 1);
            previews.value.splice(index, 1);
        } else {
            // else it means that files is zero. It means that we are in editing form, so the images are passed by props to this component. Now check if default value from props is different from null AND the typeof of default is strictly different from Array.
            if (props.default != null && typeof props.default !== Array) {
                axios
                    .delete(
                        route(`admin.api.estates.delete_gallery_image`, {
                            image: props.default[index],
                        })
                    )
                    .then((resp) => {
                        if (resp.data.success) {
                            files.value = props.default.splice(index, 1);
                            previews.value.splice(index, 1);

                            $toast.success("Immagine rimossa", {
                                position: "top-right",
                                duration: 3000,
                            });
                        }
                    });
            } else {
                files.value.splice(index, 1);
                previews.value.splice(index, 1);
            }
        }
    } else {
        previews.value = [];
    }
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
                <img :src="`${preview}`" alt="Anteprima immagine" />
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
