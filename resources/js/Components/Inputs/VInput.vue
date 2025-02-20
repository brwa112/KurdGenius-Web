<template>
    <div class="flex">
        <template v-if="hasBeforeSlot">
            <div class="bg-[#eee] flex justify-center items-center ltr:rounded-l-md rtl:rounded-r-md px-3 font-semibold border ltr:border-r-0 rtl:border-l-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">
                <slot name="before"></slot>
            </div>
        </template>
        <input class="form-input" :class="{'ltr:rounded-l-none rtl:rounded-r-none':hasBeforeSlot,'ltr:rounded-r-none rtl:rounded-l-none':hasAfterSlot}" v-bind="$attrs" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />

        <template v-if="hasAfterSlot">
            <div class="bg-[#eee] flex justify-center items-center ltr:rounded-r-md rtl:rounded-l-md px-3 font-semibold border ltr:border-l-0 rtl:border-r-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">
                <slot name="after"></slot>
            </div>
        </template>
    </div>
</template>

<script setup>
import { ref, useSlots, computed } from 'vue';

const props = defineProps({
    modelValue: {
    },
});

const emit = defineEmits(['update:modelValue']);

const slots = useSlots();

// Computed property to check if 'before' slot has content
const hasBeforeSlot = computed(() => !!slots.before);
const hasAfterSlot = computed(() => !!slots.after);
</script>
