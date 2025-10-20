<template>
    <div class="dropdown !static sm:!relative flex">
        <template v-if="!disabled">
            <VDropdown ref="dropdownRef" :placement="placement" @apply-hide="handleDropdownHide">
                <div
                    class="relative  min-w-56 w-full flex items-center gap-1.5 rounded-md leading-3 border cursor-wait font-semibold bg-white border-[#e0e6ed] dark:border-transparent dark:bg-[#121e32] text-gray-500 dark:text-white-dark">
                    <input ref="dateInput" type="text" v-model="date"
                        :placeholder="placeholder ? $t(`${parentKey}.${placeholder}`) : $t('common.select_date_range')"
                        @click="openDropdown" @focus="openDropdown" readonly
                        class=" form-input cursor-pointer focus:border-none border-none placeholder:dark:text-white-dark" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none">
                        <svg class="w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>

                <template #popper="{ hide }">
                    <div
                        class="relative p-2.5 w-fit dark:text-gray-200 dark:bg-[#1b2e4b] bg-white border !border-gray-200 dark:!border-gray-800 rounded-lg shadow-lg overflow-hidden !my-0">
                        <div class="flex gap-2 flex-col md:flex-row-reverse">
                            <!-- Calendar Panel - Mobile -->
                            <div
                                class="flatpickr-calendar-only border-gray-200 rounded-md bg-white p-1 shadow dark:bg-[#182942] ">
                                <flat-pickr v-model="internalSelection" :config="rangeCalendar"></flat-pickr>
                            </div>
                            <!-- Quick Date Options Panel - Mobile (Scrollable) -->
                            <div class="">
                                <div class="">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">
                                        {{ $t('common.quick_select') || 'Quick Select' }}
                                    </h4>
                                    <div class="gap-2 pb-2">
                                        <div class="grid grid-cols-2 md:grid-cols-1 gap-2">
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('today')">
                                                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                                {{ $t('common.today') || 'Today' }}
                                            </button>
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('yesterday')">
                                                <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
                                                {{ $t('common.yesterday') || 'Yesterday' }}
                                            </button>
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('thisWeek')">
                                                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                                {{ $t('common.this_week') || 'This Week' }}
                                            </button>
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('thisMonth')">
                                                <div class="w-1.5 h-1.5 bg-purple-500 rounded-full"></div>
                                                {{ $t('common.this_month') || 'This Month' }}
                                            </button>
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('lastMonth')">
                                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                                                {{ $t('common.last_month') || 'Last Month' }}
                                            </button>
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('thisYear')">
                                                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></div>
                                                {{ $t('common.this_year') || 'This Year' }}
                                            </button>
                                            <button
                                                class="flex-shrink-0 whitespace-nowrap px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-md transition-colors duration-150 flex items-center gap-1.5 quick-select-btn border border-gray-200 dark:border-gray-600"
                                                @click="selectQuickDate('lastYear')">
                                                <div class="w-1.5 h-1.5 bg-pink-500 rounded-full"></div>
                                                {{ $t('common.last_year') || 'Last Year' }}
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Action buttons - Mobile -->
                                    <div
                                        class="w-full flex gap-2 justify-end pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <button @click="clearSelection"
                                            class="w-full px-3 py-1.5 text-xs text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-150 border border-gray-300 dark:border-gray-600">
                                            {{ $t('common.clear') || 'Clear' }}
                                        </button>
                                        <button @click="applySelection"
                                            class="w-full px-3 py-1.5 text-xs text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-150">
                                            {{ $t('common.apply') || 'Apply' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </VDropdown>

            <input :disabled="disabled" type="text" :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)" class="form-input hidden" />
        </template>
        <template v-else>
            <div
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 font-medium text-gray-700 dark:text-gray-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ modelValue || 'No date selected' }}</span>
                </div>
            </div>
        </template>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

//flatpickr
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

// Separate reactive variables for calendar selection and display
const internalSelection = ref(''); // What's selected in calendar (hidden from input)
const displayValue = ref(''); // What's shown in the input field

const rangeCalendar = ref({
    dateFormat: 'Y-m-d',
    mode: 'range',
    inline: true,
    static: true,
    onChange: function (selectedDates, dateStr, instance) {
        // Store the selection internally but don't show in input yet
        internalSelection.value = dateStr;

        // Only update display and emit immediately if applyImmediately is true
        if (props.applyImmediately) {
            const formattedDate = formatDateRange(dateStr);
            displayValue.value = formattedDate;
            emit('update:modelValue', formattedDate);
            emit('change', formattedDate);
            emitFilterEvent(formattedDate);
        }
    }
});

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    placement: {
        type: String,
        default: 'bottom-start',
    },
    parentKey: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: '',
    },
    // Filter-specific props
    filterKey: {
        type: String,
        default: 'date_range',
    },
    applyImmediately: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue', 'change', 'apply-filter', 'clear-filter']);

const dateInput = ref(null);
const dropdownRef = ref(null);

// Computed property for the input's v-model to show display value
const date = ref('');

onMounted(() => {
    // Initialize with modelValue if provided
    if (props.modelValue) {
        displayValue.value = props.modelValue;
        date.value = props.modelValue;
        // Convert back to internal format for calendar
        internalSelection.value = convertDisplayToInternal(props.modelValue);
    }
});

// Helper function to format date range from "to" to " - " format
const formatDateRange = (dateStr) => {
    if (!dateStr) return '';

    if (dateStr.includes(' to ')) {
        return dateStr.replace(' to ', ' - ');
    }
    return dateStr;
};

// Helper function to convert display format back to internal format
const convertDisplayToInternal = (displayStr) => {
    if (!displayStr) return '';

    if (displayStr.includes(' - ')) {
        return displayStr.replace(' - ', ' to ');
    }
    return displayStr;
};

// Function to handle dropdown hide
const handleDropdownHide = () => {
    // Optional: Add any cleanup logic here
    // setTimeout(() => {
    //     buttonRef.value?.focus();
    // }, 50);
};

// Function to open dropdown and focus calendar
const openDropdown = () => {
    setTimeout(() => {
        const flatPickrInput = document.querySelector('.flatpickr-input');
        if (flatPickrInput) {
            flatPickrInput.click();
        }
    }, 150);
};

// Function to handle quick date selections
const selectQuickDate = (period) => {
    const today = new Date();
    let startDate, endDate;

    switch (period) {
        case 'today':
            startDate = endDate = new Date(today);
            break;
        case 'yesterday':
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            startDate = endDate = yesterday;
            break;
        case 'thisWeek':
            const todayForWeek = new Date();
            const currentDay = todayForWeek.getDay();
            const startOfWeek = new Date(todayForWeek);
            const daysToSubtract = currentDay === 0 ? 6 : currentDay - 1;
            startOfWeek.setDate(todayForWeek.getDate() - daysToSubtract);
            startOfWeek.setHours(0, 0, 0, 0);

            const endOfWeek = new Date(todayForWeek);
            endOfWeek.setHours(23, 59, 59, 999);

            startDate = startOfWeek;
            endDate = endOfWeek;
            break;
        case 'thisMonth':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today);
            break;
        case 'lastMonth':
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            startDate = lastMonth;
            endDate = new Date(today.getFullYear(), today.getMonth(), 0);
            break;
        case 'thisYear':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date(today);
            break;
        case 'lastYear':
            startDate = new Date(today.getFullYear() - 1, 0, 1);
            endDate = new Date(today.getFullYear() - 1, 11, 31);
            break;
        default:
            return;
    }

    // Format dates for internal storage
    const formatDate = (date) => {
        return date.toISOString().split('T')[0];
    };

    const dateRange = `${formatDate(startDate)} to ${formatDate(endDate)}`;
    internalSelection.value = dateRange;

    // If applyImmediately is true, update display immediately
    if (props.applyImmediately) {
        const formattedDate = formatDateRange(dateRange);
        displayValue.value = formattedDate;
        date.value = formattedDate;
        emit('update:modelValue', formattedDate);
        emit('change', formattedDate);
        emitFilterEvent(formattedDate);
    }
    // Otherwise, selection is stored but not displayed until Apply is clicked
};

// Function to clear the date selection
const clearSelection = () => {
    internalSelection.value = '';
    displayValue.value = '';
    date.value = '';
    emit('update:modelValue', '');
    emit('change', '');
    emit('clear-filter', props.filterKey);
};

// Helper function to format date range for filtering
const formatDateForFilter = (dateStr) => {
    if (!dateStr) return null;
    // Handle both formats: " - " and " to "
    let startDate, endDate;
    if (dateStr.includes(' - ')) {
        [startDate, endDate] = dateStr.split(' - ');
    } else if (dateStr.includes(' to ')) {
        [startDate, endDate] = dateStr.split(' to ');
    } else {
        // Single date
        return {
            date: dateStr,
            start_date: dateStr,
            end_date: dateStr,
            date_range: dateStr,
            type: 'single'
        };
    }

    return {
        start_date: startDate,
        end_date: endDate,
        date_range: dateStr,
        type: 'range'
    };
};

// Helper function to emit filter events
const emitFilterEvent = (dateStr) => {
    const filterData = formatDateForFilter(dateStr);

    emit('apply-filter', {
        key: props.filterKey,
        value: filterData,
        rawValue: dateStr
    });
};

// Function to apply the current selection and close dropdown
const applySelection = () => {
    if (internalSelection.value) {
        // Format the internal selection for display
        const formattedDate = formatDateRange(internalSelection.value);

        // Update display and emit events
        displayValue.value = formattedDate;
        date.value = formattedDate;
        emit('update:modelValue', formattedDate);
        emit('change', formattedDate);
        emitFilterEvent(formattedDate);
    }

    // Close the dropdown
    // dropdownRef.value?.hide?.();
};

// Watch for changes in modelValue prop
watch(() => props.modelValue, (newValue) => {
    if (newValue !== displayValue.value) {
        displayValue.value = newValue || '';
        date.value = newValue || '';
        // Convert back to internal format for calendar consistency
        internalSelection.value = convertDisplayToInternal(newValue || '');
    }
});

// Keep date in sync with displayValue for the input field
watch(displayValue, (newValue) => {
    date.value = newValue;
});

</script>

<style scoped>
.flatpickr-calendar-only :deep(.flatpickr-input) {
    display: none !important;
}

.flatpickr-calendar-only :deep(.flatpickr-calendar) {
    position: static !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    transform: none !important;
    box-shadow: none !important;
    border: none !important;
    background: transparent !important;
}

/* Quick select buttons animation */
.quick-select-btn {
    @apply relative overflow-hidden transition-all duration-300 ease-in-out;

}

.quick-select-btn:before {
    @apply absolute top-0 left-0 w-full h-full;
    content: '';
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
    transition: left 0.5s;
}

.quick-select-btn:hover:before {
    left: 100%;
}

.flatpickr-calendar-only :deep(.flatpickr-day) {
    @apply text-sm md:text-base flex items-center justify-center p-0 !important;
}

.flatpickr-current-month {
    @apply flex justify-between !important;
}
</style>
