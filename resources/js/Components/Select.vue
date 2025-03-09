<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: [Number, Array],
        default: null,
    },
    showEmptyOption: {
        type: Boolean,
        default: false,
    },
});

const value = computed({
    get() {
        return props.modelValue;
    },

    set(val) {
        emit('update:modelValue', val);
    },
});
</script>

<template>
    <select
        v-model="value"
        class=""
    >
        <option
            v-if="showEmptyOption"
            disabled="disabled"
            :value="null"
        >
            Выбрать
        </option>
        <option
            v-for="option in options"
            :key="option.id"
            :value="option.id"
            :selected="option.id === value"
        >
            {{ option.title }} ({{option.id}})
        </option>
    </select>
</template>
