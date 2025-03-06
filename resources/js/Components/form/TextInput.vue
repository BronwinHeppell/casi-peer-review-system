<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { onMounted, ref } from "vue";

const props = defineProps({
    icon: {
        type: Object,
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="field">
        <p class="control" :class="{ 'has-icons-left': icon }">
            <input
                class="input has-shadow has-text-grey-darker"
                v-model="model"
                ref="input"
            />
            <span class="icon is-small is-left" v-if="icon">
                <FontAwesomeIcon :icon="icon" />
            </span>
        </p>
    </div>
</template>
