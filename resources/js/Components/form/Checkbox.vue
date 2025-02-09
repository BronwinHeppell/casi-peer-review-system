<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    text: {
        type: String,
        required: true,
    },
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <label class="checkbox is-flex justify-center items-center" >
        <input
            class="checkbox mr-2"
            type="checkbox"
            :value="value"
            v-model="proxyChecked"
        />
        {{ text }}
    </label>

</template>
