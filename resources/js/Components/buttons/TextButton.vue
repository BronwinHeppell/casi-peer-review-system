<template>
    <button class="button is-text is-normal link-colour no-underline">
        <slot />
    </button>
</template>

<style scoped>
.no-underline {
    text-decoration: none;
}

.link-colour {
    color: #ea3e4d;
}
</style>
