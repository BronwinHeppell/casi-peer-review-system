<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="is-size-7 has-text-danger">
            {{ message }}
        </p>
    </div>
</template>
