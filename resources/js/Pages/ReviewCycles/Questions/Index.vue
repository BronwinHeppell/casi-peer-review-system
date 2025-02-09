<script setup>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import LinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import DangerButton from "@/Components/buttons/DangerButton.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import {faTrash} from "@fortawesome/free-solid-svg-icons/faTrash";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faPencil} from "@fortawesome/free-solid-svg-icons/faPencil";

defineOptions({layout: AuthenticatedLayout});

defineProps({
    reviewCycle: {
        type: Object,
    },
    questions: {
        type: Object,
    },
});

let selectedQuestionId = ref(null);
const showDeleteModal = ref(false);
const form = useForm({});

const confirmDelete = (id) => {
    selectedQuestionId = id;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;

    form.clearErrors();
    form.reset();
};

const deleteQuestion = () => {
    form.delete(route('questions.destroy', selectedQuestionId), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

</script>
<template>
    <section class="section">
        <!--Breadcrumbs-->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('review_cycles.index')">Review Cycles</a></li>
                <li><a :href="route('review_cycles.edit', reviewCycle.id)">Edit Review Cycle</a></li>
                <li class="is-active"><a href="#" aria-current="page">Questions</a></li>
            </ul>
        </nav>

        <!--Table-->
        <DeleteModal
            :isActive="showDeleteModal"
            @close="showDeleteModal = false"
            @confirm="deleteQuestion"
        />

        <div class="is-flex mt-2 is-justify-content-space-between is-align-items-center">
            <h1 class="title has-text-primary m-0">Questions</h1>
            <RoundedLinkButton class="is-medium" :href="route('questions.create',reviewCycle.id )">+</RoundedLinkButton>
        </div>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th><abbr title="Title">Title</abbr></th>
                <th><abbr title="Title">Category</abbr></th>
                <th><abbr title="Actions"></abbr></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="question in questions.data" :key="question.id">
                <td>{{ question.question }}</td>
                <td>{{ question.category.title }}</td>
                <td>
                    <div class="is-flex">
                        <RoundedLinkButton class="is-rounded is-small mr-2"
                                           :href="route('questions.edit',[ reviewCycle.id, question.id])">
                            <FontAwesomeIcon :icon="faPencil"/>
                        </RoundedLinkButton>
                        <DangerButton @click="confirmDelete(question.id)"
                                      class="is-danger button is-uppercase is-rounded is-small">
                            <FontAwesomeIcon :icon="faTrash"/>
                        </DangerButton>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="questions"/>
        <div class="is-flex is-justify-content-end">
            <LinkButton
                :href="questions.data.length === 0 ? '#' : route('review_cycles.finalise', reviewCycle.id)"
                class="is-primary is-medium">Finalise
                Cycle
            </LinkButton>
        </div>
    </section>
</template>

<style scoped>

</style>
