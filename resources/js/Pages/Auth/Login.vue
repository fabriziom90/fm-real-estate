<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";

import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="w-1/2 bg-white p-5 mx-auto">
            <div class="mb-5">
                <h2 class="text-2xl">Effettua l'accesso ad FM-Real-Estate</h2>
            </div>

            <form @submit.prevent="submit">
                <div>
                    <label class="label-text">Email</label>
                    <input
                        type="text"
                        placeholder="Email"
                        class="input-sm rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form.email"
                    />
                    <div v-if="form.errors.email" class="text-danger">
                        {{ form.errors.email }}
                    </div>
                </div>
                <div class="mt-5">
                    <label class="label-text">Password</label>
                    <input
                        type="password"
                        placeholder="Password"
                        class="input-sm rounded w-full border-gray-300 shadow-sm focus:border-main-blue focus:ring-main-blue"
                        v-model="form.password"
                    />
                    <div v-if="form.errors.password" class="text-danger">
                        {{ form.errors.password }}
                    </div>
                </div>

                <!-- <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ms-2 text-sm text-gray-600"
                            >Remember me</span
                        >
                    </label>
                </div> -->

                <div class="mt-4 flex items-center justify-end">
                    <!-- <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Forgot your password?
                    </Link> -->
                    <button
                        :disabled="form.processing"
                        class="tool-button bg-main-blue border-main-blue text-white m-0"
                    >
                        Login
                    </button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
