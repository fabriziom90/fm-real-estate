<script setup>
import { onMounted, ref } from "vue";

const props = defineProps({
    gallery: String,
});

const images = ref([]);
const baseUrl = ref(window.location.origin);
const activeSlide = ref(0);
const visibleThumbnails = ref([0, 1, 2]);

onMounted(() => {
    images.value = props.gallery.split(",");

    // setInterval(() => {
    //     if (activeSlide.value == images.value.length - 1) {
    //         activeSlide.value = 0;
    //     } else {
    //         activeSlide.value++;
    //     }
    //     updateThumbnails();
    // }, 3000);
});

const nextSlide = () => {
    activeSlide.value == images.value.length - 1
        ? (activeSlide.value = 0)
        : activeSlide.value++;

    updateThumbnails();
};

const prevSlide = () => {
    activeSlide.value == 0
        ? (activeSlide.value = images.value.length - 1)
        : activeSlide.value--;

    updateThumbnails();
};

const updateThumbnails = () => {
    const totalImages = images.value.length;
    visibleThumbnails.value = [
        (activeSlide.value - 1 + totalImages) % totalImages, // Indice precedente
        activeSlide.value, // Indice attivo
        (activeSlide.value + 1) % totalImages, // Indice successivo
    ];
};
</script>
<template lang="">
    <div class="carousel">
        <div class="carousel-image">
            <div class="prev-slide" @click="prevSlide()">
                <i class="fas fa-chevron-left"></i>
            </div>
            <img :src="`${baseUrl}/storage/${images[activeSlide]}`" />
            <div class="next-slide" @click="nextSlide()">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
        <div class="thumbnails">
            <img
                v-for="(image, index) in visibleThumbnails"
                :key="index"
                :src="`${baseUrl}/storage/${images[image]}`"
                :class="{ active: activeSlide === image }"
                @click="
                    activeSlide = image;
                    updateThumbnails();
                "
            />
        </div>
    </div>
</template>
<style>
.carousel-image {
    max-width: 100%;
    height: 400px;
    position: relative;
}

.carousel-image img {
    object-fit: cover;
    height: 100%;
    width: 100%;
}
.thumbnails {
    display: flex;
    height: 150px;
    padding-top: 10px;
}

.thumbnails img {
    width: calc(100% / 3);
    height: 100%;
    object-fit: cover;
    opacity: 0.5;
}

img.active {
    opacity: 1;
}

.thumbnails img:nth-child(2) {
    margin: 0px 10px;
}

.prev-slide,
.next-slide {
    position: absolute;
    top: 50%;
    background-color: #011a90;
    color: #fff;
    padding: 10px 15px;
    border-radius: 50%;
    border: 3px solid #fff;
    transition: 0.3s;
    cursor: pointer;
}

.prev-slide:hover,
.next-slide:hover {
    background-color: #0020b2;
}

.prev-slide {
    left: 10px;
}

.next-slide {
    right: 10px;
}
</style>
