<script setup>


import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import Pagination from "@/Components/Pagination.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {faEye} from "@fortawesome/free-solid-svg-icons";

defineOptions({layout: AuthenticatedLayout});

defineProps({
    reviews: {
        type: Object,
    },
    reviewType: {
        type: String,
    }
});
</script>

<template>
    <section class="section">
        <div class="is-flex my-2 is-justify-content-space-between is-align-items-center">
            <h1 class="title has-text-primary m-0">{{reviewType}} Reviews</h1>
        </div>

        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th><abbr title="Title">Title</abbr></th>
                <th><abbr title="Description">Description</abbr></th>
                <th><abbr title="Description">Reviewer</abbr></th>
                <th><abbr title="Description">Reviewee</abbr></th>
                <th><abbr title="Actions"></abbr></th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="review in reviews.data" :key="review.id">
                <td>{{ review?.review_cycle?.title }}</td>
                <td>{{ review?.review_cycle?.description }}</td>
                <td>{{ review?.reviewer?.name }} {{ review?.reviewer?.surname }}</td>
                <td>{{ review?.reviewee?.name }} {{ review?.reviewee?.surname }}</td>
                <td>
                    <div class="is-flex">
                        <RoundedLinkButton
                            class="is-rounded is-primary is-small mr-2"
                            :href="route(`reviews.${reviewType.toLowerCase()}Details`, { id: review.id, review_cycle_id: review.review_cycle_id, reviewType })">
                            <FontAwesomeIcon :icon="faEye"/>
                        </RoundedLinkButton>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="reviews"/>
    </section>
</template>

<style scoped>

</style>
