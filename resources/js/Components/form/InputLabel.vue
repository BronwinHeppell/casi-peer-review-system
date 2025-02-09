<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="is-block is-size-8 has-text-weight-medium has-text-grey-dark">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
