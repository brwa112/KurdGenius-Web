<template>
  <section class="bg-[#F4F7FF] mb-15 lg:mb-15">
    <div class="w-full sm:container 3xl:max-w-[70%] mx-auto px-4">
      <div class="relative flex flex-col items-start gap-y-5 gap-x-8 xl:gap-x-10 py-16 md:py-26">
        <!-- Left Content -->
        <div class="relative z-5 flex-1 space-y-1.5 max-w-xl xl:max-w-2xl text-justify">
          <h2 class="relative z-10 text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ $t('calendar.officialTitle') }}
          </h2>
          <p class="leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty">
            {{ $t('calendar.officialDescription') }}
          </p>
          <img :src="'/img/shape_star.svg'" alt="ShapeOne" class="absolute -top-8 -start-10 3xl:-start-21 opacity-40 3xl:opacity-100" />
        </div>

        <!-- List -->
        <div class="relative z-5">
          <ul class="list-disc list-inside -space-y-1 text-base lg:text-xl ms-6">
            <li>{{ $t('calendar.holidays.newYear') }}</li>
            <li>{{ $t('calendar.holidays.nowruz') }}</li>
            <li>{{ $t('calendar.holidays.eid') }}</li>
            <li>{{ $t('calendar.holidays.independence') }}</li>
            <li>{{ $t('calendar.holidays.teachersDay') }}</li>
          </ul>
        </div>

        <div class="absolute end-18 bottom-20 md:bottom-36 overflow-hidden opacity-20 md:opacity-100">
          <div class="size-6 bg-[#019BFF] rounded-full"></div>
        </div>
        <div class="absolute end-10 bottom-23 md:bottom-39 overflow-hidden opacity-20 md:opacity-100">
          <img :src="'/img/shape_one.png'" alt="ShapeOne" />
        </div>
        <div class="absolute end-0 bottom-14 md:bottom-30 overflow-hidden opacity-20 md:opacity-100">
          <img :src="'/img/shape_two.png'" alt="ShapeOne" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>

