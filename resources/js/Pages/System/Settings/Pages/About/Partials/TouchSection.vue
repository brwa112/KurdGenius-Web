<template>
    <div class="panel">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ $t('system.contact') }}</h5>
            <label class="relative h-6 w-12">
                <input v-model="form.is_active" type="checkbox" class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" />
                <span class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
            </label>
        </div>

        <form class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div>
                <label>{{ $t('system.contact_email') }}</label>
                <input v-model="form.contact_email" type="email" class="form-input" />
            </div>

            <div>
                <label>{{ $t('system.contact_phone') }}</label>
                <input v-model="form.contact_phone" type="text" class="form-input" />
            </div>

            <div>
                <label>{{ $t('system.contact_address') }} ({{ $t(`system.${selectLanguage.slug}`) }})</label>
                <input v-model="form.contact_address[selectLanguage.slug]" type="text" class="form-input" />
            </div>
        </form>
    </div>
</template>

<script setup>
const props = defineProps({ form: { type: Object, required: true }, selectLanguage: { type: Object, required: true } });
</script>
