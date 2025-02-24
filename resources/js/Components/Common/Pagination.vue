<template>
    <div :dir="'ltr'">
        <RenderlessPagination ref="pagination" :data="data" :limit="flexableLimit ? flexable_limit : limit"
            :keep-length="keepLength" @pagination-change-page="onPaginationChangePage" v-slot="slotProps">
            <nav v-bind="$attrs" class="inline-flex -space-x-px rounded isolate" aria-label="Pagination"
                v-if="slotProps.computed.total > slotProps.computed.perPage">
                <!-- :href="(slotProps.computed?.prevPageUrl || '').replace('http://', 'https://')" -->
                <component :is="slotProps.computed.prevPageUrl ? 'Link' : 'span'"
                    :href="slotProps.computed?.prevPageUrl"
                    class="page-link relative inline-flex -me-px rtl:rotate-180 items-center px-2 py-1 text-sm font-medium border rounded-l-md focus:z-20 disabled:opacity-50"
                    :class="itemClasses, { 'opacity-50': !slotProps.computed.prevPageUrl }"
                    :disabled="!slotProps.computed.prevPageUrl" v-on="slotProps.prevButtonEvents">
                    <slot name="prev-nav">
                        <span class="sr-only">Previous</span>
                        <svg class="size-3 md:size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </slot>
                </component>

                <component :is="page === slotProps.computed.currentPage || page == '...' ? 'span' : 'Link'"
                    :href="prepareNewUrl(page)"
                    class="page-link relative inline-flex items-center px-2 py-2 text-xs sm:text-sm font-medium border focus:z-20"
                    :class="[
                        page == slotProps.computed.currentPage ? activeClasses : itemClasses,
                        page == slotProps.computed.currentPage ? 'z-30' : '',
                    ]" :aria-current="slotProps.computed.currentPage ? 'page' : null"
                    v-for="(page, key) in updatePageRange(slotProps.computed.pageRange)" :key="key"
                    v-on="slotProps.pageButtonEvents(page)"
                    :disabled="page === slotProps.computed.currentPage || page == '...'">
                    {{ page }}
                </component>

                <component :is="slotProps.computed.nextPageUrl ? 'Link' : 'span'"
                    :href="slotProps.computed?.nextPageUrl"
                    class="page-link relative inline-flex rtl:rotate-180 items-center px-2 py-1 text-sm font-medium border rounded-r-md focus:z-20 disabled:opacity-50"
                    :class="itemClasses, { 'opacity-50': !slotProps.computed.nextPageUrl }"
                    :disabled="!slotProps.computed.nextPageUrl" v-on="slotProps.nextButtonEvents">
                    <slot name="next-nav">
                        <span class="sr-only">Next</span>
                        <svg class="size-3 md:size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </slot>
                </component>
            </nav>
        </RenderlessPagination>
    </div>
</template>

<script>
import RenderlessPagination from 'laravel-vue-pagination/src/RenderlessPagination.vue';
import { Link, usePage } from '@inertiajs/vue3';

export default {
    compatConfig: {
        MODE: 3
    },

    inheritAttrs: false,

    emits: ['pagination-change-page'],

    components: {
        RenderlessPagination,
        Link
    },
    // setup() {
    //     const store = useStore();
    //     return {
    //         store,
    //     };
    // },
    props: {
        flexableLimit: {
            type: Boolean,
            default: true
        },
        data: {
            type: Object,
            default: () => { }
        },
        limit: {
            type: Number,
            default: 3
        },
        showDisabled: {
            type: Boolean,
            default: false
        },
        keepLength: {
            type: Boolean,
            default: true
        },
        size: {
            type: String,
            default: 'default',
            validator: value => {
                return ['small', 'default', 'large'].indexOf(value) !== -1;
            }
        },
        align: {
            type: String,
            default: 'left',
            validator: value => {
                return ['left', 'center', 'right'].indexOf(value) !== -1;
            }
        },
        itemClasses: {
            type: Array,
            default: () => [
                'bg-white dark:bg-[#253b5c]',
                'text-gray-500 dark:text-gray-300',
                'border-gray-300 dark:border-gray-500',
                'hover:bg-gray-50 dark:hover:bg-gray-500',
            ],
        },
        activeClasses: {
            type: Array,
            default: () => [
                'bg-blue-50 dark:bg-blue-300',
                'border-blue-500 dark:border-blue-700',
                'text-blue-600 dark:text-blue-900',
            ],
        },
    },

    methods: {
        prepareNewUrl(page) {
            let url = usePage().props.ziggy.url + usePage().url;

            url = new URL(url);
            url.searchParams.set('page', page);

            return url.toString();
        },
        onPaginationChangePage(page) {
            this.page = page;
            this.$emit('pagination-change-page', page);
        },

        getPageNumber(url) {

            if (!url) {
                return null;
            }

            try {
                const urlObj = new URL(url);
                const params = new URLSearchParams(urlObj.search);
                const page = params.get('page');
                return page ? parseInt(page, 10) : null;
            } catch (error) {
                console.error('Invalid URL:', error);
                return null;
            }
        },

        updatePageRange(pageRange) {
            let newPageRange = [...pageRange];
            let index = newPageRange.indexOf('...');
            while (index > 0) {
                if (index > 1) {
                    newPageRange.splice(index - 1, 1); // Remove one number before "..."
                }
                if (index < newPageRange.length - 1) {
                    newPageRange.splice(index + 1, 1); // Remove one number after "..."
                }
                index = newPageRange.indexOf('...', index + 1);
            }
            return newPageRange;
        }
    },
    computed: {
        flexable_limit() {
            const current_page = this.data.meta?.current_page || 1;

            if (current_page > 100) {
                return 2;
            }

            return 3;
        }
    }
}
</script>

<style>
.page-link[disabled="true"] {
    pointer-events: none !important;
}
</style>