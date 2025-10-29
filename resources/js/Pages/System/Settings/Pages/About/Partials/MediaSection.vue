<template>
    <div class="panel">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ $t('system.media') }}</h5>
            <label class="relative h-6 w-12">
                <input v-model="form.is_active" type="checkbox" class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" />
                <span class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
            </label>
        </div>

        <form class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div>
                <label>{{ $t('system.title') }} ({{ $t(`system.${selectLanguage.slug}`) }})</label>
                <input v-model="form.title[selectLanguage.slug]" type="text" class="form-input" />
            </div>

            <div>
                <label>{{ $t('system.description') }} ({{ $t(`system.${selectLanguage.slug}`) }})</label>
                <textarea v-model="form.description[selectLanguage.slug]" class="form-input h-24"></textarea>
            </div>

            <div>
                <label>{{ $t('system.gallery') }}</label>
                <ImageUpload v-model="form.gallery" field-name="gallery" :form="form"
                    @update:form="(data) => { if (data.remove_gallery !== undefined) form.remove_gallery = data.remove_gallery; }" />
            </div>

            <div>
                <label>{{ $t('system.videos') }}</label>
                <ImageUpload v-model="form.videos" field-name="videos" :form="form"
                    @update:form="(data) => { if (data.remove_videos !== undefined) form.remove_videos = data.remove_videos; }" />
            </div>
        </form>
    </div>
</template>

<script setup>
import ImageUpload from '@/Components/Inputs/ImageUpload.vue';

const props = defineProps({ form: { type: Object, required: true }, selectLanguage: { type: Object, required: true } });
</script>
