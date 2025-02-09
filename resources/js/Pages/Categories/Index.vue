<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import {useForm} from "@inertiajs/vue3";
import DangerButton from "@/Components/buttons/DangerButton.vue";
import {ref} from "vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import Pagination from "@/Components/Pagination.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faPencil} from "@fortawesome/free-solid-svg-icons/faPencil";
import {faTrash} from "@fortawesome/free-solid-svg-icons/faTrash";

defineOptions({layout: AuthenticatedLayout});

defineProps({
    categories: {
        type: Object,
    },
});

let selectedCategoryId = ref(null);
const showModal = ref(false);
const form = useForm({});

const confirmDelete = (id) => {
    selectedCategoryId = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;

    form.clearErrors();
    form.reset();
};

const deleteCategory = () => {
    form.delete(route('categories.destroy', selectedCategoryId), {
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
            @confirm="deleteCategory"
        />

        <div class="is-flex mt-2 is-justify-content-space-between is-align-items-center">
            <h1 class="title has-text-primary m-0">Categories</h1>
            <RoundedLinkButton class="is-medium" :href="route('categories.create')">+</RoundedLinkButton>
        </div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th><abbr title="Title">Title</abbr></th>
                <th><abbr title="Description">Description</abbr></th>
                <th><abbr title="Actions"></abbr></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="category in categories.data" :key="category.id">
                <td> {{ category.title }}</td>
                <td> {{ category.description }}</td>
                <td>
                    <div class="is-flex">
                        <RoundedLinkButton class="is-rounded mr-2  is-small "
                                           :href="route('categories.edit', $id = category.id)">
                            <FontAwesomeIcon :icon="faPencil"/>
                        </RoundedLinkButton>
                        <DangerButton @click="confirmDelete(category.id)"
                                      class="is-danger button is-uppercase is-rounded is-small">
                            <FontAwesomeIcon :icon="faTrash"/>
                        </DangerButton>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="categories"/>
    </section>
</template>

<style scoped>

</style>
