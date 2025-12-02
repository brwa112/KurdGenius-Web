<template>
    <div class="panel">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ $t('system.choose_section') }}</h5>
            <!-- <label class="relative h-6 w-12">
                <input v-model="form.is_active" type="checkbox"
                    class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" />
                <span
                    class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
            </label> -->
        </div>
        <form class="space-y-5">
            <div>
                <label for="choose_description">{{ $t('system.description') }} ({{
                    $t(`system.${selectLanguage.slug}`) }})</label>
                <textarea v-model="form.description[selectLanguage.slug]" id="choose_description" rows="4"
                    class="form-textarea" :placeholder="$t('system.description')"></textarea>
                <div class="mt-1 text-sm text-danger" v-if="form.errors['description.' + selectLanguage.slug]"
                    v-html="form.errors['description.' + selectLanguage.slug]">
                </div>
            </div>

            <div>
                <label>{{ $t('system.reasons') }} ({{ $t(`system.${selectLanguage.slug}`) }})</label>
                <div class="grid md:grid-cols-2 2xl:grid-cols-3 gap-4">
                    <div v-for="(reason, index) in form.reasons[selectLanguage.slug]" :key="index"
                        class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-full flex justify-between gap-2">
                                <h6 class="font-semibold">{{ $t('system.reason') }} {{ index + 1 }}</h6>
                                <span
                                    class="px-3 py-0.5 bg-gray-50 dark:bg-gray-800 rounded text-sm text-gray-600 dark:text-gray-400">
                                    {{ getColorForIndex(index) }}
                                </span>
                            </div>
                            <button type="button" @click="removeReason(index)"
                                class="btn btn-sm btn-outline-danger px-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </button>
                        </div>

                        <div>
                            <label>{{ $t('pages.title') }}</label>
                            <input v-model="reason.title" type="text" class="form-input"
                                :placeholder="$t('pages.title')" />
                            <div class="mt-1 text-sm text-danger"
                                v-if="form.errors['reasons.' + selectLanguage.slug + '.' + index + '.title']"
                                v-html="form.errors['reasons.' + selectLanguage.slug + '.' + index + '.title']">
                            </div>
                        </div>

                        <div>
                            <label>{{ $t('system.description') }}</label>
                            <textarea v-model="reason.description" rows="2" class="form-textarea"
                                :placeholder="$t('system.description')"></textarea>
                            <div class="mt-1 text-sm text-danger"
                                v-if="form.errors['reasons.' + selectLanguage.slug + '.' + index + '.description']"
                                v-html="form.errors['reasons.' + selectLanguage.slug + '.' + index + '.description']">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-1 text-sm text-danger" v-if="form.errors['reasons.' + selectLanguage.slug]"
                    v-html="form.errors['reasons.' + selectLanguage.slug]">
                </div>
                <button type="button" @click="addReason" 
                    :disabled="form.reasons[selectLanguage.slug]?.length >= 10"
                    :class="{'opacity-50 cursor-not-allowed': form.reasons[selectLanguage.slug]?.length >= 10}"
                    class="btn btn-sm btn-primary mt-3">
                    + {{ $t('system.add_reason') }}
                </button>
                <p v-if="form.reasons[selectLanguage.slug]?.length >= 10" class="text-sm text-warning mt-2">
                    {{ $t('system.maximum_reasons_reached') }} (10/10)
                </p>
                <p v-else class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ form.reasons[selectLanguage.slug]?.length || 0 }}/10 {{ $t('system.reasons') }}
                </p>
            </div>
        </form>
    </div>
</template>

<script setup>
import { inject } from 'vue';

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    selectLanguage: {
        type: Object,
        required: true
    }
});

const $helpers = inject('helpers');

// Three colors that will repeat
const colors = [
    { bg: 'bg-[#F0457D]/100', border: 'border-[#F0457D]', name: 'Pink' },
    { bg: 'bg-[#FFD44D]/100', border: 'border-[#FFD44D]', name: 'Yellow' },
    { bg: 'bg-[#0099F5]/100', border: 'border-[#0099F5]', name: 'Blue' }
];

const getColorForIndex = (index) => {
    const colorIndex = index % 3;
    return colors[colorIndex].name;
};

const addReason = () => {
    if (!props.form.reasons[props.selectLanguage.slug]) {
        props.form.reasons[props.selectLanguage.slug] = [];
    }
    
    // Check if maximum limit reached
    if (props.form.reasons[props.selectLanguage.slug].length >= 10) {
        $helpers.toast('Maximum 10 reasons allowed', 'warning');
        return;
    }
    
    const index = props.form.reasons[props.selectLanguage.slug].length;
    const colorIndex = index % 3;

    props.form.reasons[props.selectLanguage.slug].push({
        title: '',
        description: '',
        bgColor: colors[colorIndex].bg,
        borderColor: colors[colorIndex].border
    });
};

const removeReason = (index) => {
    props.form.reasons[props.selectLanguage.slug].splice(index, 1);
};
</script>
