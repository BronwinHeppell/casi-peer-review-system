<script setup>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import DangerButton from "@/Components/buttons/DangerButton.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import {ref} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import {faPencil} from "@fortawesome/free-solid-svg-icons/faPencil";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faTrash} from "@fortawesome/free-solid-svg-icons/faTrash";

defineOptions({layout: AuthenticatedLayout});

defineProps({
    users: {
        type: Object,
    },
});

const authUser = usePage().props.auth.user;

let selectedUserId = ref(null);
const showModal = ref(false);
const form = useForm({});

const confirmDelete = (id) => {
    selectedUserId = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;

    form.clearErrors();
    form.reset();
};

const deleteUser = () => {
    form.delete(route('users.destroy', selectedUserId), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};
</script>

<template>

    <section class="section">

        <DeleteModal
            :isActive="showModal"
            @close="showModal = false"
            @confirm="deleteUser"
        />

        <div class="is-flex mt-2 is-justify-content-space-between is-align-items-center">
            <h1 class="title has-text-primary m-0">Users</h1>
            <RoundedLinkButton class="is-medium" :href="route('users.create')">+</RoundedLinkButton>
        </div>
        <table class="table is-fullwidth ">
            <thead>
            <tr>
                <th><abbr title="Name">Name</abbr></th>
                <th><abbr title="Surname">Surname</abbr></th>
                <th><abbr title="Email">Email</abbr></th>
                <th><abbr title="Role">Role</abbr></th>
                <th><abbr title="Is Admin">Is Admin</abbr></th>
                <th><abbr title="Actions"></abbr></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users.data" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.surname }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role }}</td>
                <td>{{ user.is_admin ? 'Yes' : 'No' }}</td>
                <td>
                    <div class="is-flex">
                        <RoundedLinkButton class="is-rounded  mr-2" :href="route('users.edit', user.id)">
                            <FontAwesomeIcon :icon="faPencil"/>
                        </RoundedLinkButton>
                        <DangerButton @click="confirmDelete(user.id)"
                                      :disabled="authUser.id === user.id"
                                      class="is-danger button is-uppercase is-rounded is-small">
                            <FontAwesomeIcon :icon="faTrash"/>
                        </DangerButton>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="users"/>
    </section>
</template>

<style scoped>

</style>
