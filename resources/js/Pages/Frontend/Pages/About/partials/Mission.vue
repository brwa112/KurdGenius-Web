<template>
  <section class="relative mb-10 bg-[#F4F7FF] overflow-hidden">
    <div class="w-full sm:container 3xl:max-w-[75%] mx-auto px-4">
      <div class="relative flex items-center justify-center gap-5 xl:gap-10 py-16 lg:py-27.5">
        <!-- Content -->
        <div class="relative z-5 flex-1 flex flex-col items-center space-y-3.5 max-w-xl xl:max-w-2xl text-white">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold leading-tight">
            {{ $t('mission.title') }}
          </h2>
          <p class="leading-6 text-base lg:text-lg xl:text-xl font-normal text-justify">
            {{ $t('mission.description') }} {{ $t('mission.description_full') }}
          </p>
        </div>
      </div>
      <!-- Image -->
      <div class="absolute inset-0">
        <img :src="'/img/about/bg_mission.jpg'" alt="mission"
          class="w-full h-full object-cover object-[50%_96.5%]" />
      </div>
      <div class="absolute inset-0 bg-[#0B1441]/70"></div>
      <div class="absolute inset-0 bg-black/15"></div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>


