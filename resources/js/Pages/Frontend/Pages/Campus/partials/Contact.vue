<template>
  <section class="mt-10 mb-10">
    <div class="w-full sm:container 3xl:max-w-[75%] mx-auto px-4">
      <div class="relative flex flex-col lg:flex-row items-center justify-center gap-10 lg:gap-20 xl:gap-40 py-16 lg:py-30">
        <!-- Logo -->
        <div class="block">
          <img :src="'/img/logo.png'" alt="logo" class="w-full h-55 lg:h-95 object-cover" />
        </div>
        <!-- Content -->
        <div class="relative z-5 flex-1 space-y-1.5 max-w-xl xl:max-w-2xl">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ $t('campusContact.title') }}
          </h2>
          <p class="leading-6 text-base lg:text-lg xl:text-xl font-normal text-justify">
            {{ $t('campusContact.description') }}
          </p>
          <button type="submit"
            class="bg-primary hover:bg-white text-white hover:text-primary hover:font-semibold py-3 px-2 w-40 mt-7 rounded-full border-4 border-primary transition-all duration-500 text-base font-light transform">
            {{ $t('campusContact.contact') }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>

