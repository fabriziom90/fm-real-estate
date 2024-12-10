<script setup>
import { ref } from "vue";

import Sidebar from "@/Components/Sidebar.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div>
        <Sidebar />
        <div class="min-h-screen bg-blue-main">
            <!-- Page Content -->
            <div
                class="w-[100%] md:w-[768px] lg:w-[990px] xl:w-[1250px] mx-auto pt-10"
            >
                <div class="flex flex-1 gap-5">
                    <div class="w-[120px]">
                        <a
                            :href="route('dashboard')"
                            class="main-button"
                            :class="
                                route().current() === 'dashboard'
                                    ? 'active'
                                    : ''
                            "
                        >
                            Dashboard
                        </a>
                    </div>
                    <div class="w-[120px]">
                        <a
                            :href="route('admin.immobili.index')"
                            class="main-button"
                            :class="
                                route().current() === 'admin.immobili.index'
                                    ? 'active'
                                    : ''
                            "
                        >
                            Immobili
                        </a>
                    </div>
                    <div class="w-[120px]">
                        <a href="#" class="main-button"> Clienti </a>
                    </div>
                    <div class="w-[120px]">
                        <a
                            :href="route('admin.areas.index')"
                            class="main-button"
                            :class="
                                route().current() === 'admin.areas.index'
                                    ? 'active'
                                    : ''
                            "
                        >
                            Aree
                        </a>
                    </div>
                </div>
            </div>
            <main>
                <div
                    class="w-[100%] md:w-[768px] lg:w-[990px] xl:w-[1250px] mx-auto p-8 bg-white mt-5"
                >
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
