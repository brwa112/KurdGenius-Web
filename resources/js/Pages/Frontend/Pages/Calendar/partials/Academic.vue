<template>
  <section class="w-full sm:container 3xl:max-w-[70%] mx-auto px-4 mt-15 xl:mt-30 mb-5">
    <div class="relative flex flex-col items-start gap-y-20 gap-x-8 xl:gap-x-10 py-16 pb-50 lg:pb-70 xl:pb-90 2xl:pb-100">
      <!-- Top Content -->
      <div class="relative z-5 flex-1 space-y-1.5 max-w-xl xl:max-w-2xl text-justify">
        <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
          {{ $t('calendar.academicTitle') }}
        </h2>
        <p class="leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty">
          {{ $t('calendar.academicDescription') }}
        </p>
      </div>

      <!-- Bottom Content -->
      <div class="relative z-5 grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 lg:gap-4 sm:w-11/12 mx-auto">
        <div
          class="bg-gray-50 outline-2 outline-[#0028DF] border-2 border-[#0028DF]/0 hover:border-[#0028DF] duration-500 rounded-3xl text-center p-1 lg:p-3 h-35 flex items-center justify-center w-full">
          <span class="text-sm sm:text-base lg:text-xl font-medium">
            {{ $t('calendar.activity1') }}
          </span>
        </div>
        <div
          class="bg-gray-50 outline-2 outline-[#FED176] border-2 border-[#FED176]/0 hover:border-[#FED176] duration-500 rounded-3xl text-center p-1 lg:p-3 h-35 flex items-center justify-center w-full">
          <span class="text-sm sm:text-base lg:text-xl font-medium">
            {{ $t('calendar.activity2') }}
          </span>
        </div>
        <div
          class="bg-gray-50 outline-2 outline-[#3DA8A5] border-2 border-[#3DA8A5]/0 hover:border-[#3DA8A5] duration-500 rounded-3xl text-center p-1 lg:p-3 h-35 flex items-center justify-center w-full">
          <span class="text-sm sm:text-base lg:text-xl font-medium">
            {{ $t('calendar.activity3') }}
          </span>
        </div>
        <div
          class="bg-gray-50 outline-2 outline-[#FF966D] border-2 border-[#FF966D]/0 hover:border-[#FF966D] duration-500 rounded-3xl text-center p-1 lg:p-3 h-35 flex items-center justify-center w-full">
          <span class="text-sm sm:text-base lg:text-xl font-medium">
            {{ $t('calendar.activity4') }}
          </span>
        </div>
      </div>

      <div class="absolute end-0 xl:end-5 3xl:-end-22 top-20 overflow-hidden scale-x-[-1]">
        <div class="size-48 xl:size-66 bg-[#FFDB57] rounded-full translate-x-1/2"></div>
      </div>
      <div class="absolute -end-24 xl:-end-28 3xl:-end-55 top-20 overflow-hidden scale-x-[-1]">
        <div class="size-48 xl:size-66 bg-[#FBAF49] rounded-full translate-x-1/2"></div>
      </div>
      <div class="absolute lg:start-3 3xl:-start-22 bottom-20 overflow-hidden">
        <div class="size-38 xl:size-49 bg-[#019BFF] rounded-full"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>

