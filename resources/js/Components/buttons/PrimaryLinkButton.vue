<template>
    <a
        :href="!disabled ? href : '#'"
        :class="{ 'is-disabled': disabled }"
        class="button is-primary is-uppercase is-normal has-text-white">
        <slot/>
    </a>
</template>

<script>
export default {
    props: {
        href: {
            type: String,
            required: true,
        },
        disabled: {
            type: Boolean,
            default: false,
        }
    }
};
</script>

<style scoped>
/* Style for disabled state */
.is-disabled {
    opacity: 0.5;
    pointer-events: none; /* Prevents clicking */
    cursor: not-allowed;
}
</style>
