<template>
  <section class="mt-15 mb-15 lg:mt-30 lg:mb-15 bg-white px-4">
    <div
      class="relative w-full sm:container 3xl:max-w-[90%] mx-auto border-5 border-b-0 border-primary rounded-t-4xl">
      <div class="w-5/6 mx-auto flex flex-col lg:flex-row items-center gap-5 xl:gap-10 pt-6.5 pb-38 sm:pt-12 sm:pb-45">
        <!-- Left Content -->
        <div class="flex-1 space-y-1.5">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ $t('principalMessage.title') }}
          </h2>
          <div class="relative w-full">
            <p class="leading-6 text-base lg:text-lg xl:text-xl font-normal text-pretty">
              {{ $t('principalMessage.opening') }}
            </p>
            <p class="absolute -start-5.5 sm:-start-7 -top-1 text-[32px] font-semibold">“</p>
          </div>
          <div class="mt-4">
            <a href="#" class="font-normal">
              <span>{{ $t('common.seeMore') }}</span>
              <div class="w-10 h-0.5 bg-yellow-400 rounded-full"></div>
            </a>
          </div>
        </div>

        <!-- Right Content - Images -->
        <div class="flex-1 flex lg:justify-end">
          <img :src="'/img/home/message/1.jpg'" alt="Graduation"
            class="w-full lg:w-5/6 h-84 sm:h-104 2xl:h-134 object-cover object-[0%_15%] scale-x-[-1]" />
        </div>
      </div>

      <div class="absolute -inset-x-1 bottom-0 -mx-px">
        <img :src="'/img/home/message/bottom.svg'" alt="Graduation"
          class="w-full h-30 2xl:h-34 object-cover" />
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>

