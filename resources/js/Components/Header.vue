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
            <a v-if="$page.props.auth.user" :href="route('dashboard')">
                Dashboard
            </a>
            <template v-else>
                <a :href="route('login')" class="me-4">Login </a>
            </template>
        </nav>
    </header>
</template>
