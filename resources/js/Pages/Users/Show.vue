<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import InputError from "@/Components/form/InputError.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import Dropdown from "@/Components/form/Dropdown.vue";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
    roles: {
        type: Array,
    },
})

const user = usePage().props.auth.user;

const form = useForm(
    {
        name: props.user?.name || "",
        surname: props.user?.surname || "",
        email: props.user?.email || "",
        password: props.user?.password || 'password',
        password_confirmation: props.user?.password || 'password',
        role: props.user?.role || "",
        view_rating_history: props.user?.view_rating_history || false,
        is_admin: props.user?.is_admin || false,
    }
)


const createUser = () => {
    form.post(route("users.store"), {
        onSuccess: () => form.reset()
    })
}

const updateUser = () => {
    form.put(route("users.update", props.user.id), {
        onSuccess: () => form.reset()
    })
}

const resetUserPassword = () => {
    form.put(route("users.reset_password", props.user.id), {
        onSuccess: () => form.reset()
    })
}
</script>

<template>
    <section class="section">
        <!--Breadcrumbs-->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('users.index')">Users</a></li>
                <li class="is-active"><a href="#" aria-current="page">Add Users</a></li>
            </ul>
        </nav>
        <form @submit.prevent="props.user == null ? createUser() : updateUser()" method="POST">
            <h1 class="title has-text-primary">{{ props.user == null ? 'Create new User' : 'Edit User' }}</h1>
            <!--NAME-->
            <div class="container">
                <InputLabel for="name" value="Name"></InputLabel>
                <TextInput
                    id="name"
                    class="mt-1"
                    v-model="form.name"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.name"/>
            </div>
            <!--SURNAME-->
            <div class="container  mt-4">
                <InputLabel for="surname" value="Surname"></InputLabel>
                <TextInput
                    id="surname"
                    class="mt-1"
                    v-model="form.surname"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.surname"/>
            </div>
            <!--EMAIL-->
            <div class="container  mt-4">
                <InputLabel for="email" value="Email"></InputLabel>
                <TextInput
                    id="Email"
                    class="mt-1"
                    v-model="form.email"
                    required
                    type="email"
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email"/>
            </div>
            <!-- ROLE-->
            <div class="container  mt-4">
                <InputLabel for="role" value="Role"/>
                <Dropdown
                    id="role"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                    v-model="form.role"
                    required
                >
                    <option value="" disabled>Select Role</option>
                    <option v-for="role in roles" :value="role" class="is-capitalized">{{ role }}</option>
                </Dropdown>
                <InputError class="mt-2" :message="form.errors.role"/>
            </div>

            <div class="container mt-4">
                <div class="is-flex is-flex-direction-row">
                    <InputLabel for="rating_history" value="Can View Rating History" class="mr-2"/>
                    <input
                        id="is_admin"
                        class="mt-1"
                        type="checkbox"
                        v-model="form.view_rating_history"
                    />
                </div>

                <InputError class="mt-2" :message="form.errors.view_rating_history"/>
            </div>

            <div class="container mt-4" v-if="user.is_admin">
                <div class="is-flex is-flex-direction-row">
                    <InputLabel for="is_admin" value="Is Admin" class="mr-2"/>
                    <input
                        id="is_admin"
                        class="mt-1"
                        type="checkbox"
                        v-model="form.is_admin"
                    />
                </div>
                <InputError class="mt-2" :message="form.errors.is_admin"/>
            </div>

            <div class="mt-4 is-flex is-justify-content-end">'
                <form @submit.prevent="resetUserPassword">
                    <PrimaryButton
                        v-if="user.is_admin"
                        class="mr-4 is-link"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Reset Password
                    </PrimaryButton>
                </form>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ props.user == null ? 'Create User' : 'Update User' }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

