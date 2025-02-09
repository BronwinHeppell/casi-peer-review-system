<script setup>
import {defineProps, ref, watch} from 'vue';
import InputError from "@/Components/form/InputError.vue";
import InputLabel from "@/Components/form/InputLabel.vue";
import TextInput from "@/Components/form/TextInput.vue";

const props = defineProps({
    question: String,
});

// Reactive references for current rating and comment
const currentRating = ref(0);
const comment = ref('');

// Error handling for the comment field
const formErrors = ref({
    comment: null
});

// Update parent component with rating and comment
const emit = defineEmits(['update-rating'])
const updateParent = () => {
    const ratingData = {
        stars: currentRating.value,
        comment: comment.value
    };

    emit('update-rating', ratingData);  // Emit to parent component
};

// Watch the currentRating to handle validation
watch([currentRating, comment], () => {
    if (currentRating.value <= 3 && !comment.value) {
        formErrors.value.comment = "Comment is required with ratings below 3.";
    } else {
        formErrors.value.comment = null;
    }
});

// Method to set the star rating
const setRating = (star) => {
    currentRating.value = star;
    updateParent();  // Update parent when rating changes
};

</script>

<template>
    <div class="is-flex is-flex-direction-column ">
        <p class=" is-size-5 has-text-weight-medium has-text-grey-dark m-0 [-0">{{ question }}</p>

        <!-- Star Rating -->
        <div class="stars">
            <span
                v-for="star in 5"
                :key="star"
                class="star"
                :class="{'filled': star <= currentRating}"
                @click="setRating(star)"
            >
                ★
            </span>
        </div>

        <!-- Comment Section (Required if rating <= 3) -->
        <div class="container mt-2">
            <InputLabel for="comment" value="Comment" class=""></InputLabel>
            <TextInput
                id="comment"
                class="mt-1"
                v-model="comment"
                autofocus
                v-on:change="updateParent"
            />
            <InputError class="mt-2" :message="formErrors.comment"/>
        </div>
    </div>
</template>

<style scoped>
.stars {
    display: flex;
    justify-content: start;
}

.star {
    font-size: 30px;
    cursor: pointer;
    color: #ddd;
}

.star.filled {
    color: #ffcc00;
}
</style>
