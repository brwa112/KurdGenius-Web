import { computed } from 'vue';

export function useDateFilters(filters, applyFilterCallback) {
    // Computed property to handle the date range display
    const dateRangeModel = computed({
        get() {
            return filters.start_date && filters.end_date 
                ? `${filters.start_date} - ${filters.end_date}` 
                : '';
        },
        set() {
            // Keep empty setter to avoid Vue warnings
        }
    });

    // Handle filter application from CustomDatePicker
    const handleApplyFilter = (filterData) => {
        filters.start_date = filterData.value.start_date;
        filters.end_date = filterData.value.end_date;
        applyFilterCallback();
    };

    // Handle filter clearing from CustomDatePicker
    const handleClearFilter = () => {
        filters.start_date = '';
        filters.end_date = '';
        applyFilterCallback();
    };

    return {
        dateRangeModel,
        handleApplyFilter,
        handleClearFilter
    };
}