import { reactive, computed, onMounted, getCurrentInstance, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';

const state = reactive({});
const filters = {};

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

function parseDateRange(value) {
    const dates = value.split(',');
    return dates.length === 2 && dates.every(isValidDate) ? dates.map(date => new Date(date)) : null;
}

export function initializeFilters(defaultFilters, mappings = {}) {
    const _filters = ref(defaultFilters);
    const page = usePage();

    // Store the default dates from initialization
    const defaultDates = defaultFilters.dates || [];

    // Accessing the URL from the page object
    const query = page.url.split('?')[1] || '';
    const params = new URLSearchParams(query);

    const result = {};

    // Iterate over all keys in the URLSearchParams
    for (const key of params.keys()) {
        if (key.includes('[]')) {
            // Handle multiple values and structure them as needed
            const cleanKey = key.slice(0, -2); // Properly remove the trailing '[]'
            const ids = params.getAll(key).map(id => ({ id: Number(id) }));
            if (!result[cleanKey]) {
                result[cleanKey] = ids;
            } else {
                result[cleanKey].push(...ids.filter(id => !result[cleanKey].some(existingId => existingId.id === id.id)));
            }
        } else {
            // Handle single values
            result[decodeURIComponent(key)] = decodeURIComponent(params.get(key));
        }
    }

    const filters = {};

    for (const [key, value] of Object.entries(result)) {
        let parts = key.replace(/[[]/g, '.').replace(/]/g, '').split('.');

        if (parts[parts.length - 1] === 'id') {
            parts.pop();
        }

        let current = filters;
        for (let i = 0; i < parts.length; i++) {
            const part = parts[i];

            if (i === parts.length - 1) {
                current[part] = value; // Directly assign the value array without additional nesting
            } else {
                current = current[part] = current[part] || {};
            }
        }
    }

    let _return = filters?.filter || {};

    // Apply mappings to the returned filters
    Object.keys(mappings).forEach(key => {
        if (_return[key] && typeof mappings[key] === 'function' && typeof _return[key] != 'undefined' && _return[key] != 'undefined') {
            _return[key] = mappings[key](_return[key]);
        }
    });

    // Set default dates if not present in URL parameters or if invalid
    if (!_return.dates) {
        _return.dates = defaultDates;
    } else if (Array.isArray(_return.dates) && _return.dates.length !== 2) {
        _return.dates = defaultDates;
    } else if (typeof _return.dates === 'string') {
        const dates = _return.dates.split(',');
        if (dates.length !== 2 || !dates.every(isValidDate)) {
            _return.dates = defaultDates;
        }
    }

    return _return;
}

export function updateFilters(filters = null) {
    // Use the default filters from initialization if needed
    const defaultFilters = {};

    const updatedFilters = {
        ...(filters || state),
    };

    if (!updatedFilters.dates) {
        updatedFilters.dates = defaultFilters.dates;
    }

    const query = serializeFilters(updatedFilters);
    router.get(window.location.pathname, query, { replace: true });
}

export function resetFilters() {
    // Reset with default dates from initialization
    const defaultFilters = {};
    const query = serializeFilters(defaultFilters);
    router.get(window.location.pathname, query, { replace: true });
}

export function doesFilterApplied() {
    const page = usePage();
    const query = page.url.split('?')[1] || '';
    const params = new URLSearchParams(query);
    return params.keys().next().done === false;
}

export function useFilters() {
    return state;
}

function parseFilterParams(params) {
    const filter = {};

    Object.keys(params).forEach(key => {
        // Regular expression to match the pattern `filter[something.id][]`
        const match = key.match(/^filter\[(.+?)\.id\]\[\]$/);
        if (match) {
            const field = match[1]; // Extracts 'lead_status' or 'owner'
            filter[field] = { id: (params[key]) }; // Converts string to integer and assigns to the id property
        }
    });

    return filter;
}

function serializeFilters(filters) {
    const params = new URLSearchParams();

    for (const key in filters) {
        const value = filters[key];
        if (value !== null && value !== undefined) {
            if (Array.isArray(value)) {
                value.forEach(v => {
                    if (v?.id) {
                        params.append(`filter[${key}.id][]`, v.id);
                    } else {
                        params.append(`filter[${key}]`, v);
                    }
                });
            } else {
                params.append(`filter[${key}]`, value?.id || value);
            }
        }
    }

    return params;
}