<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/form/TextInput.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import Dropdown from "@/Components/form/Dropdown.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import InputError from "@/Components/form/InputError.vue";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    question: {
        type: Object,
    },
    categories: {
        type: Object,
    },
    reviewCycleId: {
        type: Number,
    }
})

const form = useForm(
    {
        question: props.question?.question || "",
        category_id: props.question?.category_id || "",
        review_cycle_id: props.reviewCycleId.toString(),
    }
)
const createQuestion = () => {
    form.post(route("questions.store"), {
            onSuccess: () => form.reset()
        }
    );
}

const updateQuestion = () => {
    form.put(route("questions.update", props.question.id), {
        onSuccess: () => form.reset()
    })
}
</script>

<template>
    <section class="section">
        <!--Breadcrumbs-->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('review_cycles.edit', reviewCycleId)">Edit Review Cycle</a></li>
                <li><a :href="route('questions.index', reviewCycleId)" aria-current="page">Questions</a></li>
                <li class="is-active"><a href="#" aria-current="page">Add Questions</a></li>
            </ul>
        </nav>
        <form @submit.prevent="question == null ? createQuestion() : updateQuestion()" method="POST">
            <h1 class="title has-text-primary">{{ question == null ? 'Create new Question' : 'Edit Question' }}</h1>
            <!--NAME-->
            <div class="container">
                <InputLabel for="question" value="Question"></InputLabel>
                <TextInput
                    id="name"
                    class="mt-1"
                    v-model="form.question"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.question"/>
            </div>
            <!-- CATEGORY -->
            <div class="container  mt-4">
                <InputLabel for="category" value="Category"/>
                <Dropdown
                    id="category"
                    class="mt-1 block w-full border-gray-300 rounded-md"
                    v-model="form.category_id"
                    required
                >
                    <option value="" disabled>Select Category</option>
                    <option v-for="category in categories" :value="category.id" class="is-capitalized">{{
                            category.title
                        }}
                    </option>
                </Dropdown>
                <InputError class="mt-2" :message="form.errors.category_id"/>
            </div>

            <div class="mt-4 is-flex is-justify-content-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ question == null ? 'Create Question' : 'Update Question' }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style scoped>

</style>
