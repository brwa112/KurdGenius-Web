<template>
    <div :dir="direction ?? rtlClass" class="px-2 py-1.5 rounded-md" :class="{ 'text-primary': isEmpty(createdDate) }">
        <div class="dropdown !static md:!relative flex items-center gap-2">
            <Menu as="div" class="!static md:!relative inline-block text-left">
                <div>
                    <MenuButton>
                        <div class="flex">
                            <button type="button" class="whitespace-nowrap flex justify-center items-center gap-1 font-bold">
                                <span v-if="showing == 'label'"> {{ label }} </span>
                                <span v-if="showing == 'date'"> {{ formatCustomDate(createdDate) }} </span>
                                <Svg name="arrow_right" class="size-4 text-gray-500 rotate-90"></Svg>
                            </button>
                        </div>
                    </MenuButton>
                </div>

                <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                    <MenuItems class="absolute start-2 md:start-0 z-50 mt-3 w-11/12 md:w-auto min-w-40 p-1 divide-y divide-gray-100 rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black/5 focus:outline-none">
                        <div class="w-full px-1 py-1 flex flex-col lg:flex-row gap-2">

                            <div class="w-full flex flex-col gap-1 whitespace-nowrap">
                                <div v-if="typeDate == 'next'" class="flex flex-col gap-1 whitespace-nowrap">
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate()))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Today
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() - 1))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Yesterday
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() - 7))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Last 7 Days
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() - 30))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Last 30 Days
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setDateRangeToLastMonth" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Last Month
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setDateRangeToLastYear" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Last Year
                                    </button>
                                    </MenuItem>
                                </div>
                                <div v-if="typeDate == 'previous'" class="flex flex-col gap-1 whitespace-nowrap">
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() + 1))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Next Day
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() + 7))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Next Week
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() + 30))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Next Month
                                    </button>
                                    </MenuItem>
                                    <MenuItem>
                                    <button type="button" @click="setCreatedDate(dateNow.setDate(dateNow.getDate() + 365))" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                        Next Year
                                    </button>
                                    </MenuItem>
                                </div>
                                <button v-if="typeDate != 'previous' && isFeature" type="button" @click="typeDate = 'previous'" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent bg-gray-100 dark:bg-gray-700 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                    Next
                                </button>
                                <button v-if="typeDate != 'next' && isPast" type="button" @click="typeDate = 'next'" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent bg-gray-100 dark:bg-gray-700 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                    Previous
                                </button>
                                <button v-if="isCustom" type="button" @click="typeDateCustom" class="py-1.5 px-3 inline-flex items-center gap-x-2 duration-200 b-text-xs font-semibold rounded border border-transparent bg-gray-100 dark:bg-gray-700 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary">
                                    Custom Range
                                </button>
                            </div>

                            <div dir="ltr" v-if="typeDate == 'custom'" class="w-full vtd-datepicker">
                                <vue-tailwind-datepicker :shortcuts="false" v-model="createdDate" :formatter="formatter" :auto-apply="true" no-input>
                                </vue-tailwind-datepicker>
                            </div>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
            <button v-if="isEmpty(createdDate) && isClearable" type="button" @click="createdDate = null" class="mt-0.5">
                <Svg name="close" class="size-4 text-gray-500"></Svg>
            </button>
        </div>

    </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeMount, inject } from 'vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import Svg from '@/Components/Svg.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
dayjs.extend(relativeTime);

const rtlClass = inject('rtlClass');

const props = defineProps({
    modelValue: {
        type: [String, Array, Object],
        default: '',
    },
    label: {
        type: String,
        default: 'Date Range',
    },
    isDefault: {
        type: Boolean,
        default: false,
    },
    direction: {
        type: String,
        default: null,
    },
    showing: {
        type: String,
        default: 'label',
    },
    isClearable: {
        type: Boolean,
        default: true,
    },
    isFeature: {
        type: Boolean,
        default: true,
    },
    isPast: {
        type: Boolean,
        default: true,
    },
    isCustom: {
        type: Boolean,
        default: true,
    },
    'onUpdate:modelValue': {
        type: Function,
        default: () => { },
    },
    onChange: {
        type: Function,
        default: () => { },
    },
});

const createdDate = ref(props.modelValue || []);

const formatter = ref({
    date: 'YYYY-MM-DD',
    month: 'MMM',
});
const typeDate = ref();
const typeDateCustom = () => {
    if (typeDate.value == 'custom') {
        typeDate.value = 'previous';
    } else {
        typeDate.value = 'custom';
    }
};

onBeforeMount(() => {
    if (props.isDefault) {
        setCreatedDate(dateNow.setDate(dateNow.getDate() - 30));
    }
    if (props.isFeature) {
        typeDate.value = 'previous';
    } else {
        typeDate.value = 'next';
    }
    if (props.isPast) {
        typeDate.value = 'next';
    } else {
        typeDate.value = 'previous';
    }
});

const isEmpty = (value) => {
    if (Array.isArray(value)) {
        // Check for an empty array
        return value.length > 0;
    } else if (typeof value === 'object' && value !== null) {
        // Check for an empty object
        return Object.keys(value).length > 0;
    }
    return false; // Not an array or object, or is null
};

let dateNow = new Date();
const setCreatedDate = (start, end) => {
    dateNow = new Date();
    createdDate.value = {
        0: dayjs(start).format('YYYY-MM-DD'),
        1: dayjs(end).format('YYYY-MM-DD')
    };
};


const emits = defineEmits('update:modelValue', 'change');

watch(createdDate, () => {
    emits('update:modelValue', createdDate.value);
    emits('change', createdDate.value);
});

onMounted(() => {
    if (isEmpty(props.modelValue)) {
        createdDate.value = props.modelValue;
    }
});

const setDateRangeToLastMonth = () => {
    const startOfLastMonth = new Date();
    startOfLastMonth.setMonth(startOfLastMonth.getMonth() - 1);
    startOfLastMonth.setDate(1); // First day of last month

    const endOfRange = new Date();
    endOfRange.setDate(0); // Adjusted to the 7th of last month

    setCreatedDate(startOfLastMonth, endOfRange);
}

const setDateRangeToLastYear = () => {
    const startOfLastYear = new Date();
    startOfLastYear.setFullYear(startOfLastYear.getFullYear() - 1);
    startOfLastYear.setMonth(0); // First month of last year
    startOfLastYear.setDate(1); // First day of last year

    const endOfRange = new Date();
    endOfRange.setFullYear(endOfRange.getFullYear() - 1);
    endOfRange.setMonth(11); // Last month of last year
    endOfRange.setDate(31); // Last day of last year

    setCreatedDate(startOfLastYear, endOfRange);
}

function formatCustomDate(date, full_date = false) {
    // If the date is empty, return an empty string
    if (!isEmpty(date)) {
        return props.label;
    } else {
        return `${dayjs(date[0]).format('MMM DD, YYYY')} - ${dayjs(date[1]).format('MMM DD, YYYY')}`;
    }
}
</script>