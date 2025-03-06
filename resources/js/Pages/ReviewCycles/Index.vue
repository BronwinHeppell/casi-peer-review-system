<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import DangerButton from "@/Components/buttons/DangerButton.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faPencil } from "@fortawesome/free-solid-svg-icons/faPencil";
import { faTrash } from "@fortawesome/free-solid-svg-icons/faTrash";
import { faEye } from "@fortawesome/free-solid-svg-icons";

defineOptions({ layout: AuthenticatedLayout });

defineProps({
    reviewCycles: {
        type: Object,
    },
});

let selectedReviewCycleId = ref(null);
const showModal = ref(false);
const form = useForm({});

const confirmDelete = (id) => {
    selectedReviewCycleId = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;

    form.clearErrors();
    form.reset();
};

const deleteReviewCycle = () => {
    form.delete(route('review_cycles.destroy', selectedReviewCycleId), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

</script>
<template>
    <DeleteModal :isActive="showModal" @close="showModal = false" @confirm="deleteReviewCycle" />

    <section class="section">
        <div class="container">
            <!-- Header with Title and Create Button -->
            <div class="is-flex mt-2 is-justify-content-space-between is-align-items-center">
                <h1 class="title has-text-primary m-0">Review Cycles</h1>
                <RoundedLinkButton class="is-medium is-primary" :href="route('review_cycles.create')">
                    +
                </RoundedLinkButton>
            </div>

            <!-- Review Cycles Table -->
            <div class="mt-4">
                <table class="table is-striped is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Self Review</th>
                            <th>Peer Review</th>
                            <th>Manager Review</th>
                            <th>Is Active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="reviewCycle in reviewCycles.data" :key="reviewCycle.id">
                            <td>{{ reviewCycle.title }}</td>
                            <td>{{ reviewCycle.description }}</td>
                            <td><span :class="reviewCycle.is_self_review ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_self_review ? 'Yes' : 'No'
                                    }}</span></td>
                            <td><span :class="reviewCycle.is_peer_review ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_peer_review ? 'Yes' : 'No'
                                    }}</span></td>
                            <td><span :class="reviewCycle.is_manager_review ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_manager_review ? 'Yes' : 'No'
                                    }}</span></td>
                            <td><span :class="reviewCycle.is_active ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_active ? 'Yes' : 'No'
                                    }}</span></td>
                            <td>
                                <div class="is-flex">
                                    <RoundedLinkButton :disabled="!reviewCycle.is_active"
                                        class="is-rounded is-info is-small mr-2"
                                        :href="route('review_cycles.finalise', reviewCycle.id)">
                                        <FontAwesomeIcon :icon="faEye" />
                                    </RoundedLinkButton>
                                    <RoundedLinkButton :disabled="reviewCycle.is_active"
                                        class="is-rounded is-small mr-2"
                                        :href="route('review_cycles.edit', reviewCycle.id)">
                                        <FontAwesomeIcon :icon="faPencil" />
                                    </RoundedLinkButton>
                                    <DangerButton :disabled="reviewCycle.is_active"
                                        @click="confirmDelete(reviewCycle.id)"
                                        class="is-danger button is-uppercase is-rounded is-small">
                                        <FontAwesomeIcon :icon="faTrash" />
                                    </DangerButton>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :pagination="reviewCycles" />
            </div>
        </div>
    </section>
</template>

<style scoped></style>
