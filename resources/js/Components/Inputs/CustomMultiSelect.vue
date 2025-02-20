<template>
    <div class="dropdown !static sm:!relative flex">
        <template v-if="!disabled">

            <Menu v-slot="{ open,close }" as="div" class="inline-block text-left">
                <div>
                    <MenuButton>
                        <div class="flex items-center gap-2 px-2 py-1.5 rounded-md font-bold" :class="{ 'text-primary': count.length > 0, [style]: true }">
                            <button v-if="multiple == true" type="button" @click="countFocus" class="whitespace-nowrap flex justify-center items-center gap-1">
                                <span v-if="count.length > 0"> ({{ count.length }}) </span>
                                <span> {{ label }} </span>
                                <Svg name="arrow_right" class="size-4 text-gray-500 rotate-90"></Svg>
                            </button>
                            <button v-if="multiple == false" type="button" @click="countFocus" class="whitespace-nowrap flex justify-center items-center gap-1">
                                <span v-if="Object.keys(count)?.length > 0"> {{ checkObject(count.name) }} </span>
                                <span v-else> {{ label }} </span>
                                <Svg name="arrow_right" class="size-4 text-gray-500 rotate-90"></Svg>
                            </button>
                            <button v-if="count.length > 0" type="button" @click="clearCount" class="whitespace-nowrap flex justify-center items-center gap-1">
                                <Svg name="close" class="size-4 text-gray-500"></Svg>
                            </button>
                        </div>
                    </MenuButton>
                </div>

                <div v-show="open">
                    <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                        <MenuItems static class="absolute inset-x-3 sm:start-0 z-50 mt-1 min-w-80 !rounded-xl">
                            <ul class="relative whitespace-nowrap bg-white dark:bg-[#1b2e4b] border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden !my-0">
                                <li v-if="searchable" class="relative">
                                    <div class="bg-white dark:bg-[#1b2e4b] p-1.5 absolute -top-2 left-0 right-0 z-10">
                                        <div class="relative w-full">
                                            <input ref="focusInput" type="text" placeholder="Search..." v-model="countFilter" class="form-input rounded-none focus:border-gray-200 py-1.5 px-3" />
                                            <button v-if="countFilter.length > 0" type="button" @click="clearFilter" class="absolute end-0 top-2 z-20 mx-2">
                                                <Svg name="close" class="size-5 text-gray-500"></Svg>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <li :class="{ 'mt-10': searchable }" class="max-h-52 min-w-72 overflow-auto">
                                    <button type="button" v-for="(countOption, i) in countOptions" @click="selectOption(countOption,close)" class="flex items-center justify-between gap-10 p-1" :class="{ '!bg-primary/10 !text-primary': checkSelect(countOption.id) }" :key="i">
                                        <div class="flex items-center gap-2">
                                            <img v-if="countOption.image || has_image" class="inline-block size-8 rounded-full" :src="countOption?.image || `/assets/images/avatar.png`" alt="Image Description" />
                                            <slot name="prefix" :data="countOption"></slot>

                                            <div class="flex flex-col items-start">
                                                <h1>{{ countOption.label }}</h1>
                                                <p class="text-xs text-gray-500">{{ countOption.description }}</p>
                                                <p class="text-xs text-gray-500">{{ countOption?.email }}</p>
                                            </div>
                                        </div>
                                        <Svg name="check" class="size-5" :class="{ 'hidden': !checkSelect(countOption.id) }"></Svg>
                                    </button>
                                </li>
                                <li v-if="countOptions.length == 0" class="my-2">
                                    <div class="px-4 min-w-56">
                                        {{ $t('crm.no_results_found') }}
                                    </div>
                                </li>
                            </ul>
                        </MenuItems>
                    </transition>
                </div>
            </Menu>

            <input :disabled="disabled" type="text" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="form-input hidden" />
        </template>
        <template v-else>
            <div class="flex items-center gap-2 px-2 py-1.5 rounded-md font-bold " :class="{ [style]: true }">
                <span> {{ count.name }} </span>
            </div>
        </template>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, inject } from 'vue';
import { Menu, MenuButton, MenuItems } from '@headlessui/vue';
import Svg from '@/Components/Svg.vue';

const props = defineProps({
    modelValue: {
        type: [String, Array, Object],
        default: null,
    },
    list: {
        type: Array,
        required: true,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: 'name',
    },
    style: {
        type: String,
        default: '',
    },
    has_image: {
        type: Boolean,
        default: false,
    },
    searchable: {
        type: Boolean,
        default: true,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const language = inject('language');

const emit = defineEmits(['update:modelValue', 'change']);

const count = ref([]);

onMounted(() => {
    if (props.multiple) {
        count.value = props.modelValue ? props.modelValue : [];
    } else {
        count.value = props.modelValue ? props.modelValue : {};
    }
});

const countFilter = ref('');

const countOptions = computed(() => {
    return props.list
        .filter((item) => {
            const searchString = countFilter.value.toLowerCase();
            const itemName = typeof item.name === 'string' ? item.name.toLowerCase().includes(searchString) : false;
            const itemTitle = typeof item.title === 'string' ? item.title.toLowerCase().includes(searchString) : false;
            const itemDisplayName = typeof item.display_name === 'string' ? item.display_name.toLowerCase().includes(searchString) : false;
            return itemName || itemTitle || itemDisplayName;
        })
        .map((item) => ({
            ...item,
            label: item.name || item.title,
            description: item.description,
            email: item.email,
            filter: item.filter,
        }));
});

const focusInput = ref(null);
const countFocus = () => {
    setTimeout(() => {
        focusInput?.value?.focus();
    }, 100);
};

const selectOption = (option, close) => {

    if (props.multiple) {
        const index = count.value.findIndex((item) => item.id === option.id);
        if (index !== -1) {
            count.value.splice(index, 1);
        } else {
            count.value.push(option);
        }
    } else {
        count.value = option;
    }

    emit('update:modelValue', count.value);
    emit('change', count.value);

    if (!props.multiple) {
        close();
    }

};

const checkSelect = (id) => {

    if (!id || !count.value) return false;

    if (!props.multiple) {
        return count.value.id === id;
    } else {
        return count.value.some((item) => item.id === id);
    }
};

const clearFilter = () => {
    setTimeout(() => {
        countFilter.value = '';
    }, 100);
};

const clearCount = () => {
    count.value = [];
    emit('update:modelValue', count.value);
    emit('change', count.value);
};

const checkObject = (value) => {
    if (typeof value === 'object' && value !== null) {
        return value[language.value] || value['en'];
    }

    return value;
};
</script>