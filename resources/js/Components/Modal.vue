<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from "vue";

const props = defineProps({
    show: Boolean,
    id: Number,
    message: String,
});

const emit = defineEmits(["close", "confirmDelete"]);
const dialog = ref();
const showSlot = ref(props.show);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = "hidden";

            dialog.value?.showModal();
        } else {
            document.body.style.overflow = "";

            setTimeout(() => {
                dialog.value?.close();
                showSlot.value = false;
            }, 200);
        }
    }
);

const close = () => {
    emit("close");
};
</script>

<template>
    <dialog
        class="z-50 m-0 min-h-full min-w-full overflow-y-auto bg-transparent backdrop:bg-transparent"
        ref="dialog"
    >
        <div
            class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
            scroll-region
        >
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-show="show"
                    class="fixed inset-0 transform transition-all"
                    @click="close"
                >
                    <div class="absolute inset-0 bg-gray-500 opacity-75" />
                </div>
            </Transition>

            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <div
                    v-show="show"
                    class="p-5 fixed top-20 left-1/4 transform overflow-hidden bg-white shadow-xl transition-all sm:w-[90%] sm:mx-auto md:w-[900px] md:mx-auto"
                >
                    <h2 class="text-2xl border-b pb-5">
                        Conferma cancellazione
                    </h2>
                    <div class="py-10">
                        {{ message }}
                    </div>
                    <div class="border-t pt-5">
                        <button
                            class="tool-button text-white bg-danger border-danger"
                            @click="emit('confirmDelete')"
                        >
                            Cancella
                        </button>
                        <button
                            class="tool-button text-white bg-gray-500 border-gray-500"
                            @click="close()"
                        >
                            Chiudi
                        </button>
                    </div>
                </div>
            </Transition>
        </div>
    </dialog>
</template>
