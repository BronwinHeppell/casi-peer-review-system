<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import InputError from "@/Components/form/InputError.vue";
import {useForm} from "@inertiajs/vue3";

defineOptions({layout: AuthenticatedLayout});

const props = defineProps({
    userRating: {
        type: Object,
    },
    selfRating: {
        type: Object,
    },
    peerRating: {
        type: Object,
    },
    managerRating: {
        type: Object,
    },
});

const form = useForm(
    {
        manager_comment: props.userRating?.manager_comment || "",
        comment: props.userRating?.comment || "",
    }
);

const submit = () => {
    form.put(route("user_ratings.update",  props.userRating.id),
        {
            onSuccess: () => form.reset()
        }
    )
}
</script>

<template>
    <section class="section">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a :href="route('user_ratings.index')">Users Ratings</a></li>
                <li><a :href="route('user_ratings.show', userRating.user.id)">{{ userRating.user.name }} {{userRating.user.surname}} Rating</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ userRating.review_cycle?.title }} User Rating</a></li>
            </ul>
        </nav>
            <h1 class="title has-text-primary">{{ userRating.review_cycle?.title }} User Rating</h1>
            <!--RATINGS-->
            <div class="is-flex is-justify-content-space-evenly">
                <div v-if="selfRating"
                     class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                    <h1 class="subtitle">Self Rating</h1>
                    <div :class="selfRating > 3 ? 'is-success' : selfRating < 3 ? 'is-danger' : 'is-warning'"
                         class="rating-circle tag">
                        <span>{{ selfRating }}</span>
                    </div>
                </div>

                <div v-if="peerRating"
                     class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                    <h1 class="subtitle">Peer Rating</h1>
                    <div :class="peerRating > 3 ? 'is-success' : peerRating < 3 ? 'is-danger' : 'is-warning'"
                         class="rating-circle tag">
                        <span>{{ peerRating }}</span>
                    </div>
                </div>

                <div v-if="managerRating"
                     class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center">
                    <h1 class="subtitle">Manager Rating</h1>
                    <div :class="managerRating > 3 ? 'is-success' : managerRating < 3 ? 'is-danger' : 'is-warning'"
                         class="rating-circle tag">
                        <span>{{ managerRating }}</span>
                    </div>
                </div>
            </div>
        <form @submit.prevent="submit()" method="POST">
            <!--TITLE-->
            <div class="container mt-4">
                <InputLabel for="manager_comment" value="Manager Comment"></InputLabel>
                <TextInput
                    id="managerComment"
                    class="mt-1"
                    v-model="form.manager_comment"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.manager_comment"/>
            </div>
            <!--DESCRIPTION-->
            <div class="container mt-4">
                <InputLabel for="comment" value="Comment"></InputLabel>
                <TextInput
                    id="comment"
                    class="mt-1"
                    v-model="form.comment"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.comment"/>
            </div>

            <div class="container mt-4 is-flex is-justify-content-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Add comments
                </PrimaryButton>
            </div>
        </form>
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
