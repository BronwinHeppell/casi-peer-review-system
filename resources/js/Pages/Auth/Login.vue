<script setup>
import Checkbox from '@/Components/form/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/form/InputError.vue';
import InputLabel from '@/Components/form/InputLabel.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import TextInput from '@/Components/form/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Logo from "@/Components/Logo.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <div class="is-fullwidth is-flex is-justify-content-center">
            <Logo width="150px" height="150px"/>
        </div>

        <div v-if="status" class="mb-4 has-text-weight-medium has-text-success">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 "
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Email"

                />


                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />

                <InputError :message="form.errors.password"/>
            </div>

            <Link
                :href="route('register')"
            >
                Dont have an account? Register now!
            </Link>

            <div class="mt-4 is-flex is-justify-content-flex-end is-align-items-center">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
