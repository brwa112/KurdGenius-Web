<template>
    <div>
        <vue-tailwind-datepicker v-slot="{ value, clear }" :model-value="dateValue"
            @update:model-value="updateDateValue" as-single :formatter="formatter">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-md -mb-3" :class="style">
                <button type="button" class="whitespace-nowrap flex justify-center items-center gap-1 font-bold">
                    <span>
                        {{ dateValue || $t('crm.select') + ' ' + $t('crm.date') }}
                    </span>
                    <Svg name="arrow_right" class="size-4 text-gray-500 rotate-90"></Svg>
                </button>
                <button v-if="dateValue" type="button" @click="clear">
                    <Svg name="close" class="size-4 text-gray-500"></Svg>
                </button>
            </div>
        </vue-tailwind-datepicker>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import Svg from '@/Components/Svg.vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        default: 'name',
    },
    style: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const dateValue = ref(props.modelValue);

watch(() => props.modelValue, (newValue) => {
    dateValue.value = newValue;
});

const updateDateValue = (value) => {
    dateValue.value = value;
    emit('update:modelValue', value);
};

const formatter = ref({
    date: 'YYYY-MM-DD',
    month: 'MMM',
});

</script>