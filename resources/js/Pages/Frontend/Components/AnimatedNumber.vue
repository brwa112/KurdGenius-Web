<template>
    <Vue3Odometer :value="number" :theme="theme" :duration="duration" :format="format" :animation="animation" />
</template>

<script setup>
import Vue3Odometer from 'vue3-odometer'

const props = defineProps({
    number: {
        type: Number,
        required: true
    },
    theme: {
        type: String,
        default: 'default' // Options: 'default', 'minimal', 'digital', 'car', 'plaza', 'slot-machine', 'train-station'
    },
    duration: {
        type: Number,
        default: 1000 // Animation duration in milliseconds
    },
    format: {
        type: String,
        default: '(,ddd)' // Number format pattern
    },
    animation: {
        type: String,
        default: 'slide' // Animation type: 'slide', 'count'
    }
});
</script>

<style>
/* Import odometer default theme globally */
@import 'odometer/themes/odometer-theme-default.css';

.odometer.odometer-auto-theme,
.odometer.odometer-theme-default {
    font-family: 'Montserrat', sans-serif;
}
</style>


