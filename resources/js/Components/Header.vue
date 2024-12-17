<script setup>
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>
<template lang="">
    <header class="bg-white">
        <nav
            class="h-14 flex flex-1 items-center justify-between mx-5"
            v-if="canLogin"
        >
            <div class="flex items-center">
                <img class="w-10 me-3" src="/mylogo.png" alt="FM Real Estate" />
                <span>Fm Real Estate</span>
            </div>

            <!-- <a v-if="$page.props.auth.user != null" :href="route('dashboard')">
                Dashboard
            </a> -->

            <a :href="route('login')" class="me-4">Login </a>
        </nav>
    </header>
</template>

<style>
header {
    height: 60px;
}
</style>
