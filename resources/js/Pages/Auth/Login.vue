<script setup>
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import TextButton from "@/Components/buttons/TextButton.vue";
import InputError from "@/Components/form/InputError.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import Logo from "@/Components/Logo.vue";
import { faEnvelope, faLock } from "@fortawesome/free-solid-svg-icons";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
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
    token: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const resetPassword = () => {
    form.post(route("password.email"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <section>
        <div class="is-fullwidth is-flex is-justify-content-center is-flex-direction-column has-text-centered">
            <Logo width="150px" height="40px" />
            <h1 class="subtitle has-text-grey-light">Peer Review System</h1>
        </div>

        <div v-if="status" class="mb-4 has-text-weight-medium has-text-success">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1" v-model="form.email" case="lower" required autofocus
                    autocomplete="username" placeholder="" :icon="faEnvelope" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" placeholder="" :icon="faLock" />

                <InputError :message="form.errors.password" />
            </div>

            <div class="is-flex is-justify-content-space-between is-align-items-center">
                <Link :href="route('register')" class="has-text-weight-medium">
                Register a new account
                </Link>
                <TextButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    v-on:click="resetPassword">
                    Forgot password?
                </TextButton>
            </div>

            <div class="mt-4 is-flex is-justify-content-flex-end is-align-items-center">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="is-fullwidth">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>