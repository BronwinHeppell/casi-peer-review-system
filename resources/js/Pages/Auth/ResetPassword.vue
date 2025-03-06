<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/form/InputError.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import TextInput from "@/Components/form/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Logo from "@/Components/Logo.vue";
import SecondaryButton from "@/Components/buttons/SecondaryButton.vue";

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
    email: {
        type: String,
        required: true,
    },
});

const form = useForm({
    email: props.email,
    password: "",
    token: props.token ?? "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.store"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <div class="is-fullwidth is-flex is-justify-content-center">
            <Logo width="190px" height="190px" />
        </div>

        <h1 class="subtitle is-flex is-justify-content-center">
            Reset Password
        </h1>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="New Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="is-flex is-justify-content-space-between mt-4">
                <Link :href="route('login')" class="mt-1"> Back to Login </Link>
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
