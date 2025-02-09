<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryLinkButton from "@/Components/buttons/PrimaryLinkButton.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import SecondaryLinkButton from "@/Components/buttons/SecondaryLinkButton.vue";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    reviewCycle: {
        type: Object,
    },
    groupedQuestions: {
        type: Object,
    },
});

const form = useForm();

const startReviewCycle = () => {
    form.put(route('review_cycles.start', props.reviewCycle.id), {
            onSuccess: () => form.reset()
        }
    );
}

const endReviewCycle = () => {
    form.put(route('review_cycles.end', props.reviewCycle.id), {
            onSuccess: () => form.reset()
        }
    );
}
</script>

<template>
    <!--Breadcrumbs-->
    <!--    <nav class="breadcrumb" aria-label="breadcrumbs">-->
    <!--        <ul>-->
    <!--            <li><a :href="route('review_cycles.edit', reviewCycle.id)">Edit Review Cycle</a></li>-->
    <!--            <li><a :href="route('questions.index', reviewCycle.id)" aria-current="page">Questions</a></li>-->
    <!--            <li class="is-active"><a href="#" aria-current="page">Finalise Review Cycle</a></li>-->
    <!--        </ul>-->
    <!--    </nav>-->
    <section class="section">
        <div class="container">
            <!-- Review Cycle Title & Description -->
            <h1 class="title has-text-primary mb-2">{{ reviewCycle.title }}</h1>
            <h2 class="subtitle has-text-grey">{{ reviewCycle.description }}</h2>

            <!-- Review Cycle Details -->
            <div class=" mb-5">
                <h3 class="title is-5 has-text-dark">Review Cycle Details</h3>
                <div class="is-flex is-justify-content-space-evenly">
                    <div class="">
                        <p><strong>Self Review:</strong> <span
                            :class="reviewCycle.is_self_review ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_self_review ? 'Yes' : 'No'
                            }}</span></p>
                    </div>
                    <div class="">
                        <p><strong>Peer Review:</strong> <span
                            :class="reviewCycle.is_peer_review ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_peer_review ? 'Yes' : 'No'
                            }}</span></p>
                    </div>
                    <div class="">
                        <p><strong>Manager Review:</strong> <span
                            :class="reviewCycle.is_manager_review ? 'tag is-success' : 'tag is-danger'">{{
                                reviewCycle.is_manager_review ? 'Yes' : 'No'
                            }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Question Details -->
            <h3 class="title is-5 has-text-dark">Question Details</h3>

            <div v-for="(questions, category) in groupedQuestions" :key="category" class="mb-5">
                <h4 class="has-text-grey title is-6">{{ category }}</h4>
                <div class="content">
                    <ul class="ml-4">
                        <li v-for="question in questions" :key="question.id" class="mb-2">
                            <span class="icon has-text-primary"><i class="fas fa-question-circle"></i></span>
                            {{ question.question }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <form @submit.prevent="reviewCycle.is_active ? endReviewCycle() : startReviewCycle()" method="POST">
            <div class="is-flex is-justify-content-end">
                <SecondaryLinkButton  :href="route('review_cycles.index')" class="mr-2">
                    Home
                </SecondaryLinkButton>
                <PrimaryButton :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    {{ reviewCycle.is_active ? 'Complete' : 'Start' }} Review Cycle
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style scoped>

</style>
