<template>
    <multiselect :label="label" :track-by="trackBy" :options="list" class="custom-multiselect w-full whitespace-nowrap"
        v-model="valueInput" :multiple="multiple"
        :placeholder="placeholder ? $t('crm.please_select') : ''" :value="modelValue" selected-label=""
        select-label="" deselect-label="">
        <template v-slot:noResult>
            {{ $t('crm.no_results_found') }}
        </template>
        <template v-slot:option="{ option }">
            <div v-if="option && typeof option === 'object' && option !== null" class="w-full flex items-center gap-2">
                <slot name="prefix" :data="option"></slot>

                <span>{{ checkObject(option[label]) }} {{ option.value ? ' - ' : '' }}</span>
                <span>{{ option.value }}</span>
            </div>
            <div v-if="option && typeof option === 'string' && option !== null" class="w-full flex items-center gap-2">
                <span>{{ option }}</span>
            </div>
        </template>
        <template v-slot:singleLabel="{ option }">
            <div v-if="option && typeof option === 'object' && option !== null" class="w-full flex items-center">
                <span>{{ checkObject(option[label]) }} {{ option.value ? ' - ' : '' }}</span>
                <span>{{ option.value }}</span>
            </div>
        </template>
    </multiselect>
</template>

<script setup>
import { ref, watch, onMounted, inject } from 'vue';
import Multiselect from '@suadelabs/vue3-multiselect';
import '@suadelabs/vue3-multiselect/dist/vue3-multiselect.css';

const props = defineProps({
    list: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: [String, Array, Object],
        default: '',
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: 'name',
    },
    trackBy: {
        default: 'id',
    },
    placeholder: {
        type: Boolean,
        default: true,
    },
});

const language = inject('language');

const emits = defineEmits(['update:modelValue']);

const valueInput = ref(props.modelValue);

onMounted(() => {
    valueInput.value = props.modelValue;
});

watch(() => props.modelValue, (newValue) => {
    valueInput.value = newValue;
});

watch(valueInput, (newValue) => {
    emits('update:modelValue', newValue);
});

const checkObject = (value) => {
    if (typeof value === 'object' && value !== null) {
        return value[language.value] || value['en'];
    }

    return value;
};
</script>

<style>
.multiselect__content {
    width: 100% !important;
}
</style>