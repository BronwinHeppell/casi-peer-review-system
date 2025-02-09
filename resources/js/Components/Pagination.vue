<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    pagination: Object
})
</script>

<template>
    <nav class="pagination is-centered is-justify-content-center" role="navigation" aria-label="pagination">
        <template v-for="link in pagination.links" :key="link.label">
            <Link
                preserve-scroll
                :href="link.url ?? ''"
                v-html="link.label"
                class="pagination-link"
                :class="{ 'is-current': link.active, 'is-disabled': !link.url }"
            />
        </template>
    </nav>
</template>
