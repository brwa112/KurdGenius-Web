<template>
    <div class="mx-auto">
        <div class="w-full flex flex-wrap items-center justify-between gap-x-5 gap-y-2.5 -mt-1">
            <ul class="flex space-x-2 rtl:space-x-reverse">
                <li class="text-gray-500">
                    <span>{{ $t('pages.pages') }}</span>
                </li>
                <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2">
                    <span>{{ $t('pages.campus') }}</span>
                </li>
            </ul>
            <!-- Add new row -->
            <div class="block">
                <!-- Trigger -->
                <div class="flex items-center justify-center">
                    <button v-if="$can('create_campus')" type="button"
                        class="btn btn-sm btn-primary shadow-none flex items-center gap-1" @click="toggleModal()">
                        <Svg name="new" class="size-4"></Svg>
                        <span>{{ $t('common.new') }} {{ $t('pages.campus_item') }}</span>
                    </button>
                </div>

                <!-- Create Modal -->
                <TransitionRoot appear :show="showModal" as="template">
                    <Dialog as="div" @close="toggleModal()" class="relative z-50">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                            enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <DialogOverlay class="fixed inset-0 bg-[black]/60" />
                        </TransitionChild>

                        <div class="fixed inset-0 overflow-y-auto">
                            <div class="flex min-h-full items-start justify-center px-4 py-8">
                                <TransitionChild as="template" enter="duration-300 ease-out"
                                    enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100"
                                    leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                                    leave-to="opacity-0 scale-95">
                                    <DialogPanel
                                        class="panel border-0 p-0 overflow-hidden rounded-lg w-full max-w-4xl text-black dark:text-white-dark">
                                        <button type="button"
                                            class="absolute top-4 ltr:right-4 rtl:left-4 text-gray-400 hover:text-gray-800 dark:hover:text-gray-600 outline-none"
                                            @click="toggleModal()">
                                            <Svg name="close" class="size-6"></Svg>
                                        </button>
                                        <div
                                            class="b-text-lg font-bold bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]">
                                            <span v-if="form.id">
                                                {{ $t('common.edit') }}
                                            </span>
                                            <span v-else>
                                                {{ $t('common.new') }}
                                            </span>
                                            {{ $t('pages.campus_item') }}
                                        </div>
                                        <div class="p-5">
                                            <form @submit.prevent="save()" v-shortkey="['ctrl', 's']" @shortkey="save"
                                                class="space-y-5">
                                                <!-- Language Tabs -->
                                                <div class="border-b border-gray-200 dark:border-gray-700">
                                                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                                                        <li v-for="lang in Languages" :key="lang" class="mr-2">
                                                            <button type="button" @click="language = lang" :class="{
                                                                'border-primary text-primary': language === lang,
                                                                'border-transparent': language !== lang
                                                            }"
                                                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-primary hover:border-primary">
                                                                {{ $t(`common.${lang}`) }}
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 b-text-sm">
                                                    <!-- Name (Multilingual) -->
                                                    <div class="col-span-full">
                                                        <label :for="'name_' + language">
                                                            {{ $t('common.name') }} ({{ $t(`common.${language}`) }})
                                                        </label>
                                                        <input :id="'name_' + language" type="text"
                                                            v-model="form.name[language]" :placeholder="$t('common.name')"
                                                            class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors['name.' + language] }" />
                                                        <div class="mt-1 text-danger" v-if="form.errors['name.' + language]"
                                                            v-html="form.errors['name.' + language]">
                                                        </div>
                                                    </div>

                                                    <!-- Description (Multilingual) -->
                                                    <div class="col-span-full">
                                                        <label :for="'description_' + language">
                                                            {{ $t('common.description') }} ({{ $t(`common.${language}`) }})
                                                        </label>
                                                        <textarea :id="'description_' + language" rows="3"
                                                            v-model="form.description[language]"
                                                            :placeholder="$t('common.description')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors['description.' + language] }"></textarea>
                                                        <div class="mt-1 text-danger"
                                                            v-if="form.errors['description.' + language]"
                                                            v-html="form.errors['description.' + language]">
                                                        </div>
                                                    </div>

                                                    <!-- Full Description (Multilingual) -->
                                                    <div class="col-span-full">
                                                        <label :for="'full_description_' + language">
                                                            {{ $t('pages.full_description') }} ({{ $t(`common.${language}`) }})
                                                        </label>
                                                        <textarea :id="'full_description_' + language" rows="6"
                                                            v-model="form.full_description[language]"
                                                            :placeholder="$t('pages.full_description')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors['full_description.' + language] }"></textarea>
                                                        <div class="mt-1 text-danger"
                                                            v-if="form.errors['full_description.' + language]"
                                                            v-html="form.errors['full_description.' + language]">
                                                        </div>
                                                    </div>

                                                    <!-- Location (Multilingual) -->
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label :for="'location_' + language">
                                                            {{ $t('pages.location') }} ({{ $t(`common.${language}`) }})
                                                        </label>
                                                        <input :id="'location_' + language" type="text"
                                                            v-model="form.location[language]"
                                                            :placeholder="$t('pages.location')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors['location.' + language] }" />
                                                        <div class="mt-1 text-danger"
                                                            v-if="form.errors['location.' + language]"
                                                            v-html="form.errors['location.' + language]">
                                                        </div>
                                                    </div>

                                                    <!-- Address (Multilingual) -->
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label :for="'address_' + language">
                                                            {{ $t('common.address') }} ({{ $t(`common.${language}`) }})
                                                        </label>
                                                        <input :id="'address_' + language" type="text"
                                                            v-model="form.address[language]"
                                                            :placeholder="$t('common.address')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors['address.' + language] }" />
                                                        <div class="mt-1 text-danger"
                                                            v-if="form.errors['address.' + language]"
                                                            v-html="form.errors['address.' + language]">
                                                        </div>
                                                    </div>

                                                    <!-- Phone -->
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="phone">
                                                            {{ $t('pages.phone') }}
                                                        </label>
                                                        <input id="phone" type="text" v-model="form.phone"
                                                            :placeholder="$t('pages.phone')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors.phone }" />
                                                        <div class="mt-1 text-danger" v-if="form.errors.phone"
                                                            v-html="form.errors.phone">
                                                        </div>
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="email">
                                                            {{ $t('pages.email') }}
                                                        </label>
                                                        <input id="email" type="email" v-model="form.email"
                                                            :placeholder="$t('pages.email')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors.email }" />
                                                        <div class="mt-1 text-danger" v-if="form.errors.email"
                                                            v-html="form.errors.email">
                                                        </div>
                                                    </div>

                                                    <!-- Map URL -->
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="map_url">
                                                            {{ $t('pages.map_url') }}
                                                        </label>
                                                        <input id="map_url" type="url" v-model="form.map_url"
                                                            :placeholder="$t('pages.map_url')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors.map_url }" />
                                                        <div class="mt-1 text-danger" v-if="form.errors.map_url"
                                                            v-html="form.errors.map_url">
                                                        </div>
                                                    </div>

                                                    <!-- Facilities -->
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="facilities">
                                                            {{ $t('pages.facilities') }}
                                                        </label>
                                                        <input id="facilities" type="text" v-model="form.facilities"
                                                            :placeholder="$t('pages.facilities')" class="form-input"
                                                            :class="{ 'border border-red-300 rounded-md': form.errors.facilities }" />
                                                        <div class="mt-1 text-danger" v-if="form.errors.facilities"
                                                            v-html="form.errors.facilities">
                                                        </div>
                                                    </div>

                                                    <!-- Featured Image -->
                                                    <div class="col-span-full">
                                                        <label for="featured_image">
                                                            {{ $t('pages.featured_image') }}
                                                        </label>
                                                        <ImageUplaod v-model="featuredImageForm.featured_image"
                                                            v-model:form="featuredImageForm" />
                                                        <div class="mt-1 text-danger" v-if="form.errors.featured_image"
                                                            v-html="form.errors.featured_image">
                                                        </div>
                                                    </div>

                                                    <!-- Gallery -->
                                                    <div class="col-span-full">
                                                        <label for="gallery">
                                                            {{ $t('pages.gallery') }}
                                                        </label>
                                                        <ImageUplaod v-model="galleryForm.gallery"
                                                            v-model:form="galleryForm" :multiple="true" />
                                                        <div class="mt-1 text-danger" v-if="form.errors.gallery"
                                                            v-html="form.errors.gallery">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end items-center mt-5">
                                                    <button @click="toggleModal()" type="button"
                                                        class="btn btn-outline-danger">
                                                        {{ $t('common.discard') }}
                                                    </button>
                                                    <button :disabled="form.processing"
                                                        class="btn btn-primary ltr:ml-4 rtl:mr-4">
                                                        <Spinner v-if="form.processing" />
                                                        {{ $t('common.save') }}
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </Dialog>
                </TransitionRoot>
            </div>
        </div>
        <div class="pt-5">
            <div class="panel pb-0">

                <!-- Datatable -->
                <Datatable :rows="campus" :columns="columns" :totalRows="campus.data?.length" @change="apply_filter"
                    v-model:search="filters.search" v-model:numberRows="filters.number_rows" :filter="props.filter"
                    v-model:sortBy="filters.sort_by" v-model:sortDirection="filters.sort_direction">

                    <template #name="data">
                        <div class="b-text-sm font-bold">{{ data.value.name }}</div>
                    </template>

                    <template #featured_image="data">
                        <button type="button" @click="showImage(data.value.featured_image_url)"
                            class="flex items-center gap-2 text-center">
                            <img :src="data.value.featured_image_url ? data.value.featured_image_url : `/assets/images/avatar.png`"
                                class="size-10 rounded-md max-w-none" alt="featured-image" />
                        </button>
                    </template>

                    <template #updated_at="data">
                        <span v-tippy dir="ltr" class="b-text-sm font-bold ltr">
                            {{ data.value.updated_at ? $helpers.formatCustomDate(data.value.updated_at) : '' }}
                        </span>
                        <tippy>{{ $helpers.formatCustomDate(data.value.updated_at, true) }}</tippy>
                    </template>

                    <template #created_at="data">
                        <span v-tippy dir="ltr" class="b-text-sm font-bold ltr">
                            {{ data.value.created_at ? $helpers.formatCustomDate(data.value.created_at) : '' }}
                        </span>
                        <tippy>{{ $helpers.formatCustomDate(data.value.created_at, true) }}</tippy>
                    </template>

                    <template v-if="$can('edit_campus') || $can('delete_campus')" #actions="data">
                        <div class="flex gap-2">
                            <div v-if="$can('edit_campus')" class="text-center">
                                <button type="button" v-tippy @click="toggleModal(data.value)">
                                    <Svg name="pencil" class="size-5"></Svg>
                                </button>
                                <tippy>{{ $t('common.edit') }}</tippy>
                            </div>
                            <div v-if="$can('delete_campus')" class="text-center">
                                <button type="button" v-tippy @click="callDelete(data.value.id)">
                                    <Svg name="trash" class="size-5"></Svg>
                                </button>
                                <tippy>{{ $t('common.delete') }}</tippy>
                            </div>
                        </div>
                    </template>

                </Datatable>

                <vue-easy-lightbox :visible="visible" :imgs="items" :index="index" scrollDisabled moveDisabled loop
                    :class="{ minimal: !allcontrols }" @hide="
                        index = null;
                    visible = false;
                    ">
                </vue-easy-lightbox>

            </div>
        </div>
    </div>
</template>
<script setup>
import { inject, ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogOverlay } from '@headlessui/vue';
import { wTrans, trans } from 'laravel-vue-i18n';
import Swal from 'sweetalert2';
import Svg from '@/Components/Svg.vue';
import Spinner from '@/Components/Spinner.vue';
import Datatable from '@/Components/Datatable.vue';
import { initializeFilters, updateFilters } from '@/Plugins/FiltersPlugin';
import VueEasyLightbox from 'vue-easy-lightbox';
import ImageUplaod from '@/Components/Inputs/ImageUpload.vue';

const props = defineProps([
    'campus',
    'filter',
]);

const $helpers = inject('helpers');
const Languages = usePage().props.languages;
const language = ref(Languages[0]);

const items = ref([]);
const index = ref(null);
const allcontrols = ref(true);
const visible = ref(false);

const showImage = (src) => {
    items.value = [
        {
            src: src,
        },
    ];
    index.value = 0;
    visible.value = true;
};

const filters = initializeFilters({
    search: '',
    number_rows: 10,
    sort_by: 'id',
    sort_direction: 'desc',
});

const apply_filter = () => {
    updateFilters({
        ...filters,
    });
};

let form = useForm({
    id: '',
    name: { en: '', ckb: '', ar: '' },
    description: { en: '', ckb: '', ar: '' },
    full_description: { en: '', ckb: '', ar: '' },
    location: { en: '', ckb: '', ar: '' },
    address: { en: '', ckb: '', ar: '' },
    phone: '',
    email: '',
    map_url: '',
    facilities: '',
    featured_image: null,
    remove_featured_image: false,
    gallery: [],
    remove_gallery: false,
});

const featuredImageForm = ref({});
const galleryForm = ref({});

watch(featuredImageForm.value, (newValue) => {
    form.featured_image = newValue.featured_image;
    form.remove_featured_image = newValue.remove_featured_image;
});

watch(galleryForm.value, (newValue) => {
    form.gallery = newValue.gallery;
    form.remove_gallery = newValue.remove_gallery;
});

const save = () => {
    if (featuredImageForm?.value) {
        form.featured_image = featuredImageForm.value.featured_image instanceof File ? featuredImageForm.value.featured_image : null;
        form.remove_featured_image = featuredImageForm.value.remove_featured_image;
    }

    if (galleryForm?.value) {
        form.gallery = Array.isArray(galleryForm.value.gallery) ? galleryForm.value.gallery : [];
        form.remove_gallery = galleryForm.value.remove_gallery;
    }

    if (form?.id) {
        form.post(route('control.pages.campus.update', form.id), {
            onSuccess: () => {
                toggleModal();
                $helpers.toast(trans('common.record') + ' ' + trans('common.updated'));
            },
        });
        return;
    }

    form.post(route('control.pages.campus.store'), {
        onSuccess: () => {
            toggleModal();
            $helpers.toast(trans('common.record') + ' ' + trans('common.created'));
        },
    });
}

const toggleModal = (row) => {
    if (row) {
        form = useForm({
            id: row.id,
            name: row.name || { en: '', ckb: '', ar: '' },
            description: row.description || { en: '', ckb: '', ar: '' },
            full_description: row.full_description || { en: '', ckb: '', ar: '' },
            location: row.location || { en: '', ckb: '', ar: '' },
            address: row.address || { en: '', ckb: '', ar: '' },
            phone: row.phone || '',
            email: row.email || '',
            map_url: row.map_url || '',
            facilities: row.facilities || '',
            featured_image: '',
            remove_featured_image: false,
            gallery: [],
            remove_gallery: false,
        });

        featuredImageForm.value = {
            featured_image: row.featured_image_url,
            remove_featured_image: false,
        };

        galleryForm.value = {
            gallery: row.gallery_images || [],
            remove_gallery: false,
        };
    }
    showModal.value = !showModal.value;

    if (!showModal.value) {
        form = useForm({
            id: '',
            name: { en: '', ckb: '', ar: '' },
            description: { en: '', ckb: '', ar: '' },
            full_description: { en: '', ckb: '', ar: '' },
            location: { en: '', ckb: '', ar: '' },
            address: { en: '', ckb: '', ar: '' },
            phone: '',
            email: '',
            map_url: '',
            facilities: '',
            featured_image: null,
            remove_featured_image: false,
            gallery: [],
            remove_gallery: false,
        });

        featuredImageForm.value = {
            featured_image: '',
            remove_featured_image: false,
        };

        galleryForm.value = {
            gallery: [],
            remove_gallery: false,
        };
    }
};

const showModal = ref(false);

const columns = ref([
    {
        field: 'id',
        title: 'ID',
        width: '25px',
        type: 'number',
    },
    {
        field: 'name',
        title: wTrans('common.name')
    },
    {
        field: 'location',
        title: wTrans('pages.location'),
    },
    {
        field: 'phone',
        title: wTrans('pages.phone'),
    },
    {
        field: 'featured_image',
        title: wTrans('pages.featured_image'),
        sort: false,
    },
    {
        field: 'updated_at',
        title: wTrans('common.updated_at'),
        type: 'date',
        hide: true,
    },
    {
        field: 'created_at',
        title: wTrans('common.created_at'),
        type: 'date',
    },
    {
        field: 'actions',
        title: wTrans('common.actions'),
        width: '50px',
        sort: false,
    },
]) || [];

const callDelete = (id) => {
    Swal.fire({
        icon: 'warning',
        title: trans('common.are_you_sure'),
        text: trans('common.delete_this'),
        showCancelButton: true,
        confirmButtonText: trans('common.confirm'),
        cancelButtonText: trans('common.cancel'),
        padding: '2em',
        customClass: 'sweet-alerts',
    }).then((result) => {
        if (result.value) {
            form.delete(route('control.pages.campus.destroy', id), {
                onSuccess: () => {
                    $helpers.toast(trans('common.record') + ' ' + trans('common.deleted'));
                },
            });
        }
    });
};

</script>
