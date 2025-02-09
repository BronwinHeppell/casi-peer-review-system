<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import RoundedLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import Pagination from "@/Components/Pagination.vue";
import {faEye} from "@fortawesome/free-solid-svg-icons";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    user: {
        type: Object,
    },
    userRatings: {
        type: Array,
    },
    averageRating: {
        type: Object,
    },
});

</script>

<template>
    <section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('user_ratings.index')">Users Ratings</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ user.name }} {{ user.surname }} Ratings</a></li>
            </ul>
        </nav>
        <h1 class="title has-text-primary">User Ratings for {{ user.name }} {{ user.surname }}</h1>
        <div class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
            <h1 class="subtitle">Average User Rating</h1>
            <div :class="averageRating > 3 ? 'is-success' : averageRating < 3 ? 'is-danger' : 'is-warning'" class="rating-circle tag">
                <span>{{ averageRating }}</span>
            </div>
        </div>

        <div class="is-flex mt-6 is-justify-content-space-between is-align-items-center">
            <h1 class="title m-0">History</h1>
        </div>
        <table class="table is-fullwidth mt-2">
            <thead>
            <tr>
                <th><abbr title="ReviewCycle">Review Cycle</abbr></th>
                <th><abbr title="Rating">Rating</abbr></th>
                <th><abbr title="Comment">Comment</abbr></th>
                <th><abbr title="ManagerComment">Manager Comment</abbr></th>
                <th><abbr title="Actions"></abbr></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="rating in userRatings.data" :key="rating.id">
                <td>{{ rating.review_cycle?.title }}</td>
                <td><span :class="rating.average_rating > 3 ? 'tag is-success' : rating.average_rating < 3?  'tag is-danger' : 'tag is-warning'">{{
                        rating.average_rating
                    }}</span></td>
                <td>{{ rating.comment }}</td>
                <td>{{ rating.manager_comment }}</td>
                <td>
                    <div class="is-flex">
                        <RoundedLinkButton class="is-rounded  mr-2" :href="route('user_ratings.history', rating.id)">
                            <FontAwesomeIcon :icon="faEye"/>
                        </RoundedLinkButton>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination :pagination="userRatings"/>
    </section>
</template>

<style scoped>
.rating-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
