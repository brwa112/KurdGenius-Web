<template>
    <div class="flex">
        <input :type="type" :placeholder="placeholder" :value="input"
            @input="$emit('update:input', $event.target.value)"
            class="form-input ltr:rounded-r-none rtl:rounded-l-none flex-1" />
        <div
            class="bg-[#eee] flex justify-center items-center rounded-md rounded-s-none border ltr:border-l-0 rtl:border-r-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">
            <div class="dropdown">
                <Popper :placement="rtlClass === 'rtl' ? 'bottom-start' : 'bottom-end'" offsetDistance="0"
                    class="align-middle">
                    <button type="button"
                        class="btn !bg-white dark:!bg-gray-700 rounded-none outline-none border-none overflow-hidden rounded-e shadow-none b-text-xs px-2">
                        <span>{{ selected.name }}</span>
                        <Svg name="arrow_left" class="size-4.5 -rotate-90 -me-1"></Svg>
                    </button>
                    <template #content="{ close }">
                        <ul @click="close()"
                            class="whitespace-nowrap border border-gray-100 dark:border-gray-700 !py-1 max-h-64 overflow-y-auto">
                            <li v-for="item in list" :key="item.id">
                                <button type="button" @click="selectLang(item)"
                                    :class="{ 'bg-gray-100 dark:bg-gray-700': selected.id === item.id }"
                                    class="flex items-center justify-between gap-1 w-full text-left px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span>{{ item.name }}</span>
                                    <span class="text-primary">{{ selected.id === item.id ? '✔' : '' }}</span>
                                </button>
                            </li>
                        </ul>
                    </template>
                </Popper>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, inject, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Svg from '@/Components/Svg.vue';

const rtlClass = inject('rtlClass');

const props = defineProps({
    input: {
        type: String,
        default: '',
    },
    lang: {
        // type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text',
    },
    placeholder: {
        type: String,
        default: '',
    },
});

const emits = defineEmits(['update:input', 'update:lang']);

const list = ref([
    { id: 1, name: 'EN', value: 'en' },
    { id: 2, name: 'AR', value: 'ar' },
    { id: 3, name: 'KU', value: 'ckb' },
]);

const selected = ref(list.value[0]);

// Watch for changes in the selected lang and emit the update
watch(selected, (newValue) => {
    emits('update:lang', newValue);
});

const selectLang = (item) => {
    selected.value = item;
};
</script>
