<template>
    <div class="panel">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ $t('frontend.calendar.important_title') }}</h5>
            <!-- <label class="relative h-6 w-12">
                <input v-model="form.is_active" type="checkbox"
                    class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" />
                <span
                    class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
            </label> -->
        </div>
        <form class="space-y-5">
            <div>
                <label>{{ $t('system.important_dates') }} ({{ $t(`system.${selectLanguage.slug}`) }})</label>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    <div v-for="(event, index) in form.events[selectLanguage.slug]" :key="index"
                        class="grid grid-cols-1 lg:grid-cols-2 gap-2 items-start py-2.5 px-1.5">
                        <div>
                            <label class="text-xs">{{ $t('system.event_name') }}</label>
                            <input v-model="event.name" type="text" class="form-input"
                                :placeholder="$t('system.event_name')" />
                            <div class="mt-1 text-sm text-danger"
                                v-if="form.errors['events.' + selectLanguage.slug + '.' + index + '.name']"
                                v-html="form.errors['events.' + selectLanguage.slug + '.' + index + '.name']">
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <label class="text-xs">{{ $t('system.date') }}</label>
                                <input v-model="event.date" type="text" class="form-input"
                                    :placeholder="$t('system.date')" />
                                <div class="mt-1 text-sm text-danger"
                                    v-if="form.errors['events.' + selectLanguage.slug + '.' + index + '.date']"
                                    v-html="form.errors['events.' + selectLanguage.slug + '.' + index + '.date']">
                                </div>
                            </div>
                            <button type="button" @click="removeEvent(index)"
                                class="btn btn-sm btn-outline-danger px-1.5 mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-1 text-sm text-danger" v-if="form.errors['events.' + selectLanguage.slug]"
                    v-html="form.errors['events.' + selectLanguage.slug]">
                </div>
                <button type="button" @click="addEvent" class="btn btn-sm btn-primary mt-2">
                    + {{ $t('system.add_important_date') }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
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

const addEvent = () => {
    if (!props.form.events[props.selectLanguage.slug]) {
        props.form.events[props.selectLanguage.slug] = [];
    }
    props.form.events[props.selectLanguage.slug].push({ name: '', date: '' });
};

const removeEvent = (index) => {
    props.form.events[props.selectLanguage.slug].splice(index, 1);
};
</script>
