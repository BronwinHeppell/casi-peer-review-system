<script setup>
const model = defineModel({
    type: String,
    required: true,
});

</script>

<template>
    <div class="select">
        <select class="is-capitalized" v-model="model">
            <slot/>
        </select>
    </div>
</template>
