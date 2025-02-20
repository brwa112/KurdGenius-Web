<template>
    <label class="relative">
        <input @input="$emit('update:modelValue', $event.target.checked)" :checked="modelValue" type="checkbox"
            class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" />
        <span
            class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
    </label>
</template>

<script>
export default {
    name: 'CustomSwitch',
    props: {
        modelValue: {
            default: false
        },
    },
    emits: ['update:modelValue'],
}
</script>