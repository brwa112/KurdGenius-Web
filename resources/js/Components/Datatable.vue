<template>
    <!-- <div class="datatable relative" :class="{ 'pb-5': customers?.length == 0 }"> -->
    <div class="datatable relative">

        <!-- table header -->
        <div class="w-full flex items-center justify-between py-1 px-1.5 bg-[#f6f8fa] dark:bg-[#1a2941] border border-b-0 border-gray-100 dark:border-[#191e3a]">
            <div class="relative block sm:min-w-64">
                <input v-model="search" type="text" class="form-input h-8 shadow-none pe-8" :placeholder="$t('common.search')" />
                <Svg name="search" class="size-3 absolute end-2 top-1/2 -translate-y-1/2"></Svg>
            </div>
            <div class="flex items-center gap-2">
                <!-- Export Btn -->
                <vue3-json-excel v-if="exportable" type="xlsx" :data="prepareData(props.rows)" :name="namefile" class="btn btn-sm shadow-none duration-0 border cursor-pointer font-semibold bg-white border-[#e0e6ed] dark:border-[#253b5c] dark:bg-[#1b2e4b] text-gray-500 dark:text-white-dark">
                    {{ $t('common.export') }}
                </vue3-json-excel>
                <!-- columns filter -->
                <div class="dropdown">
                    <Popper :placement="rtlClass === 'rtl' ? 'bottom-end' : 'bottom-start'" offsetDistance="0" class="align-middle">
                        <button type="button" class="flex items-center border font-semibold bg-white border-[#e0e6ed] dark:border-[#253b5c] rounded-md p-1 text-sm dark:bg-[#1b2e4b] text-gray-700 dark:text-white-dark">
                            <Svg name="columns" class="size-5"></Svg>
                        </button>
                        <template #content>
                            <ul class="whitespace-nowrap">
                                <template v-for="(col, i) in columns" :key="i">
                                    <li>
                                        <div class="flex items-center px-4 py-1">
                                            <label class="cursor-pointer mb-0">
                                                <input type="checkbox" class="form-checkbox" :id="`chk-${i}`" :value="col.field" @change="(e) => $helpers.updateDatatableColumnVisibility(col, e.target.checked, columns)" :checked="!col.hide" />
                                                <span :for="`chk-${i}`" class="ltr:ml-2 rtl:mr-2">
                                                    {{ col.title }}
                                                </span>
                                            </label>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </template>
                    </Popper>
                </div>
            </div>
        </div>
        <vue3-datatable @sortChange="sortChanged" ref="datatable" :skin="skin" :columns="columns" :rows="filtered(props.rows)" v-bind="$attrs" :hasCheckbox="checkable" :sortable="true" :sortColumn="sort_column" :sortDirection="sort_direction" :firstArrow="double_arrows" :lastArrow="last_arrow" :previousArrow="previous_arrow" :nextArrow="next_arrow" class="alt-pagination">
            <template v-for="column in columns" v-slot:[column.field]="data">
                <slot v-if="hasSlot(column.field)" :name="column.field" v-bind="data"></slot>
                <template v-else>
                    {{ typeof column?.format == 'function' ? column.format(get_property(props.rows.find(x => x.id == data.value.id), column.field),props.rows.find(x => x.id == data.value.id))  : get_property(props.rows.find(x => x.id == data.value.id), column.field)}}
                </template>
            </template>
        </vue3-datatable>
    </div>
</template>

<script setup>
import { inject, onMounted, ref, useSlots, defineAsyncComponent } from 'vue';
import Vue3Datatable from '@bhplugin/vue3-datatable';
import Svg from '@/Components/Svg.vue';
import vue3JsonExcel from 'vue-json-excel3';

const sort_column = ref(null);
const sort_direction = ref(null);

const sortChanged = (column) => {

    // const mapping = {
    //     customer: 'customer_name'
    // }

    // if (mapping[column.field]) {
    //     sort_column.value = mapping[column.field];
    // } else {
    //     sort_column.value = column.field;
    // }

    // sort_direction.value = sort_direction.value !== 'asc' ? 'asc' : 'desc';
};

const search = ref('');

const $helpers = inject('helpers');
const rtlClass = inject('rtlClass');

const props = defineProps({
    columns: Array,
    rows: Array,
    skin: {
        type: String,
        default: 'whitespace-nowrap table-hover table-striped'
    },
    searchable: {
        type: Boolean,
        default: true
    },
    customize_column: {
        type: Boolean,
        default: true
    },
    exportable: {
        type: Boolean,
        default: true
    },
    checkable: {
        type: Boolean,
        default: true
    }
});

console.log(props.columns);

const datatable = ref(null)

const columns = ref(props.columns);

const filtered = (rows) => {
    return rows.filter(row => {
        return Object.values(row).some(value => {
            return String(value).toLowerCase().includes(search.value.toLowerCase());
        });
    });
};

const slots = useSlots();

onMounted(() => {
    // columns.value = columns.value.map(col => $helpers.getDatatableColumnVisibility(col))
});

const resetDatatable = () => {
    datatable.value.reset();
};

const clearSearchInput = () => {
    search.value = '';
};

defineExpose({
    clearSearchInput,
    resetDatatable
});

const hasSlot = (name) => {
    return slots[name] !== undefined;
};

const options = {
    timeZone: 'Asia/Baghdad',
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
};

const formatter = new Intl.DateTimeFormat('en-GB', options);
const parts = formatter.formatToParts(new Date());

const currentTimestamp = `${parts.find(p => p.type === 'year').value}_${parts.find(p => p.type === 'month').value}_${parts.find(p => p.type === 'day').value}_${parts.find(p => p.type === 'hour').value}_${parts.find(p => p.type === 'minute').value}_${parts.find(p => p.type === 'second').value}`;
const namefile = `Data_${currentTimestamp}.xlsx`;
const prepareData = (data) => {
    return data.map(row => {
        return columns.value.filter(x => !x?.hide && !x?.field?.toString()?.startsWith('action')).map(col => {
            return {
                [col.title]: typeof col.export_format == 'function' ? col.export_format(row) : get_property(row, col.field)
            }
        }).reduce((acc, cur) => {
            return { ...acc, ...cur }
        }, {})
    })
};

const get_property = (obj, prop) => {
    var parts = prop.split(".");

    if (parts.length === 1) {
        return obj[prop];
    }

    if (Array.isArray(parts)) {
        var last = parts.pop(),
            l = parts.length,
            i = 1,
            current = parts[0];

        while ((obj = obj[current]) && i < l) {
            current = parts[i];
            i++;
        }

        if (obj) {
            return obj[last];
        }
    } else {
        throw "parts is not valid array";
    }
}

const double_arrows = '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /> </svg>';
const last_arrow = '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg> ';
const previous_arrow = '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>';
const next_arrow = '<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>';

</script>