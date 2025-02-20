<template>
    <div class="flex">
        <input :type="type" :placeholder="placeholder" :value="price" @input="$emit('update:price', $event.target.value)" class="form-input ltr:rounded-r-none rtl:rounded-l-none flex-1" />
        <div class="bg-[#eee] flex justify-center items-center font-semibold rounded-md ltr:rounded-l-none rtl:rounded-r-none border ltr:border-l-0 rtl:border-r-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">
            <div class="dropdown">
                <Popper :placement="rtlClass === 'rtl' ? 'bottom-start' : 'bottom-end'" offsetDistance="0" class="align-middle">
                    <button type="button" class="btn outline-none border-none shadow-none btn-sm text-sm font-bold dropdown-toggle px-3.5">
                        <span>{{ selected.symbol }}</span>
                    </button>
                    <template #content="{ close }">
                        <ul @click="close()" class="whitespace-nowrap border border-gray-100 dark:border-gray-700 !py-1 max-h-64 overflow-y-auto">
                            <li v-for="item in list" :key="item.id">
                                <button type="button" @click="selectCurrency(item)" :class="{ 'bg-gray-100 dark:bg-gray-700': selected.id === item.id }" class="flex items-center justify-between gap-1 w-full text-left px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span>{{ item.symbol + ' - ' + item.name }}</span>
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

const rtlClass = inject('rtlClass');

const props = defineProps({
    price: {
        type: String,
        default: '',
    },
    currency: {
        // type: Object,
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

const emits = defineEmits(['update:price', 'update:currency']);

const list = usePage().props.common.currencies;

const selected = ref(props?.currency || list[1]);

// Watch for changes in the selected currency and emit the update
watch(selected, (newValue) => {
    emits('update:currency', newValue);
});

const selectCurrency = (item) => {
    selected.value = item;
};
</script>
