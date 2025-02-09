<script setup>
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import InputError from "@/Components/form/InputError.vue";
import TextArea from "@/Components/form/TextArea.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    category: {
        type: Object,
    },
});

const form = useForm({
    title: props.category?.title || "",
    description: props.category?.description || "",
});

const createCategory = () => {
    form.post(route('categories.store'), {
        onFinish: () => form.reset(),
    });
}

const updateCategory = () => {
    form.put(route("categories.update", props.category.id), {
        onSuccess: () => form.reset()
    })
}
</script>

<template>
    <section class="section">
        <!--Breadcrumbs-->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('categories.index')">Categories</a></li>
                <li class="is-active"><a href="#" aria-current="page">Add Categories</a></li>
            </ul>
        </nav>
        <form @submit.prevent="category == null ? createCategory() : updateCategory()" method="POST">
            <h1 class="title has-text-primary">Categories</h1>
            <div class="container">
                <InputLabel id="title" value="Title"/>
                <TextInput
                    id="title"
                    class="mt-1"
                    v-model="form.title"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="container mt-4">
                <InputLabel id="description" value="Description"/>
                <TextArea
                    id="description"
                    class="mt-1"
                    v-model="form.description"
                    required
                    type="textarea"

                />
                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div class="mt-4 is-flex is-justify-content-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ category == null ? 'Create Category' : 'Update Category' }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style scoped>

</style>
