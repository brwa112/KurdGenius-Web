<template>
  <div class="block min-h-[100dvh]">
    <Approach :approach="approach" />
    <Choose :choose="choose" />
  </div>
</template>

<script setup>
import Approach from './partials/Approach.vue';
import Choose from './partials/Choose.vue';
import PublicLayout from '@/Pages/Frontend/Layouts/Public.vue';

defineProps({
  approach: {
    type: Object,
    default: null
  },
  choose: {
    type: Object,
    default: null
  }
});

defineOptions({
  layout: PublicLayout
});
</script>

