<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import Rating from "@/Components/Rating.vue";
import {computed, onMounted, ref} from "vue";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    review: {
        type: Object,
    },
    questions: {
        type: Array,
        default: [],
    },
    roles: {
        type: Array,
    },
    reviewType: {
        type: String,
    }
});
const ratings = ref([]);

const form = useForm({
    ratings: ratings.value,
    review_id: props.review.id,
});

const loadRatings = () => {
    ratings.value = Object.keys(props.questions).map((category) => {
        return props.questions[category].map((question) => ({
            review_id: props.review.id,
            question_id: question.id,
            reviewer_id: usePage().props.auth.user.id,
            rating: 0,
            comment: '',
        }));
    }).flat();
};

onMounted(loadRatings);

const updateRating = (id, updatedRating) => {
    const ratingData = {
        review_id: props.review.id,
        question_id: id,
        reviewer_id: usePage().props.auth.user.id,
        comment: updatedRating.comment,
        rating: updatedRating.stars
    };
    const existingRatingIndex = ratings.value.findIndex(rating => rating.question_id == ratingData.question_id);

    if (existingRatingIndex !== -1) {
        ratings.value[existingRatingIndex] = ratingData;
    }
};

const isValid = computed(() => {
    return ratings.value.every(rating => {
        return !(rating.rating <= 3 && !rating.comment.trim());
    });
});


const submitReview = () => {
    form.ratings = ratings.value;
    form.review_id = props.review.id;

    form.post(route('reviews.complete'), form.data, {
        onFinish: () => form.reset(),
        forceFormData: true,
    },);
}
</script>

<template>
    <section class="section">
        <!--Breadcrumbs-->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route(`reviews.${reviewType.toLowerCase()}`)">{{reviewType}} Reviews</a></li>
                <li class="is-active"><a href="#" aria-current="page">Review</a></li>
            </ul>
        </nav>
        <form @submit.prevent="submitReview" method="POST">
            <h1 class="title has-text-primary">{{review.review_cycle.title}}</h1>
            <h2 class="subtitle has-text-primary">Review for {{review.reviewee.name}} {{review.reviewee.surname}}</h2>
            <!--NAME-->
            <div>
                <div v-for="(questions, category) in questions" :key="category" class="mb-5">

                    <h4 class="has-text-grey title is-6">{{ category }}</h4>
                    <div class="content">
                        <div v-for="(question, index) in questions" :key="index" class="mb-6">
                            <Rating
                                :question="question.question"
                                @update-rating="updateRating(question.id, $event)"
                            />
                        </div>
                    </div>

                    <hr class="has-background-grey-light my-6"/>
                </div>
            </div>

            <div class="mt-4 is-flex is-justify-content-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !isValid"
                >
                    Finish Review
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
