<template>
  <section class="mt-15 mb-15 lg:mt-30 lg:mb-15 bg-[#F4F7FF]">
    <div class="w-full sm:container 3xl:max-w-[75%] mx-auto px-4">
      <!-- Header Line -->
      <div class="w-36 h-1 bg-black rounded-full mx-auto"></div>
      <div class="flex flex-col lg:flex-row gap-5 xl:gap-10 pt-16 pb-16 lg:pt-30 lg:pb-20">
        <!-- Left Content -->
        <div class="flex-1 space-y-1.5">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ $t('history.title') }}
          </h2>
          <p class="leading-6 text-base lg:text-lg xl:text-xl font-normal text-pretty">
            {{ $t('history.description') }}
          </p>
          <div class="mt-4">
            <a href="#" class="font-normal">
              <span>{{ $t('common.seeMore') }}</span>
              <div class="w-10 h-0.5 bg-yellow-400 rounded-full"></div>
            </a>
          </div>
        </div>

        <!-- Right Content - Images -->
        <div class="flex-1 flex items-end gap-4 sm:gap-8">
          <div class="rounded-3xl overflow-hidden">
            <img :src="'/img/home/history/2.jpg'" alt="Graduation"
              class="w-full h-47.5 sm:h-67.5 2xl:h-97.5 object-cover" />
          </div>
          <div class="rounded-2xl overflow-hidden">
            <img :src="'/img/home/history/1.jpg'" alt="Graduation"
              class="w-full h-94 sm:h-114 2xl:h-144 object-cover" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>

