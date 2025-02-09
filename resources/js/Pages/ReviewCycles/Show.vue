<script setup>

import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/form/TextInput.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import InputError from "@/Components/form/InputError.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import LinkButton from "@/Components/buttons/PrimaryLinkButton.vue";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    reviewCycle: {
        type: Object,
    },

});
const form = useForm(
    {
        title: props.reviewCycle?.title || "",
        description: props.reviewCycle?.description || "",
        is_peer_review: props.reviewCycle?.is_peer_review || false,
        is_self_review: props.reviewCycle?.is_self_review || false,
        is_manager_review: props.reviewCycle?.is_manager_review || false,
        is_active: props.reviewCycle?.is_active || false,
    }
);
const createReviewCycle = () => {
    form.post(route("review_cycles.store"),
        {}
    )
}

const updateReviewCycle = () => {
    console.log(form.data())
    form.put(route("review_cycles.update", props.reviewCycle.id),
        {
            onSuccess: () => form.reset(),
        }
    );
}
</script>

<template>
    <section class="section">
        <!--Breadcrumbs-->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('review_cycles.index')">Review Cycles</a></li>
                <li class="is-active"><a href="#" aria-current="page">Add Review Cycles</a></li>
            </ul>
        </nav>
        <form @submit.prevent="reviewCycle == null ? createReviewCycle() : updateReviewCycle()" method="POST">
            <h1 class="title has-text-primary">{{ reviewCycle == null ? 'Create new Review Cycle' : 'Edit Review Cycle' }}</h1>
            <!--TITLE-->
            <div class="container mt-4">
                <InputLabel for="title" value="Title"></InputLabel>
                <TextInput
                    id="title"
                    class="mt-1"
                    v-model="form.title"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.title"/>
            </div>
            <!--DESCRIPTION-->
            <div class="container mt-4">
                <InputLabel for="description" value="Description"></InputLabel>
                <TextInput
                    id="description"
                    class="mt-1"
                    v-model="form.description"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div class="container mt-4 ">
                <label class="checkbox  mr-4">
                    <input type="checkbox" v-model="form.is_self_review"/>
                    Self review
                </label>
                <label class="checkbox  mr-4">
                    <input type="checkbox" v-model="form.is_peer_review"/>
                    Peer review
                </label>
                <label class="checkbox">
                    <input type="checkbox" v-model="form.is_manager_review"/>
                    Manager review
                </label>
            </div>
            <InputError class="mt-2" :message="form.errors.review_type"/>

            <div class="container mt-4 is-flex is-justify-content-end">
                <LinkButton v-if="reviewCycle != null" class="is-info mr-4"
                            :href="route('questions.index', reviewCycle.id)">Add
                    Questions
                </LinkButton>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ reviewCycle == null ? 'Create Review Cycle' : 'Update Review Cycle' }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style scoped>

</style>
