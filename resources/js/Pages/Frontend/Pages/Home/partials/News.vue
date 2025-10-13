<template>
  <section class="w-full sm:container 3xl:max-w-[85%] mx-auto px-4">
    <div class="flex flex-col gap-10 xl:gap-15 py-3 md:py-8 lg:py-16">
      <!-- Top Content -->
      <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-2">
        <div class="flex-1 space-y-1.5">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ trans('news.title') }}
          </h2>
          <p
            class="leading-6 text-base lg:text-lg xl:text-xl font-normal text-pretty max-w-md lg:max-w-xl xl:max-w-2xl">
            {{ trans('news.description') }}
          </p>
        </div>
        <div class="md:mx-4 mt-4">
          <a href="#" class="font-normal">
            <span>{{ trans('common.seeMore') }}</span>
            <div class="w-10 h-0.5 bg-yellow-400 rounded-full"></div>
          </a>
        </div>
      </div>

      <!-- Right Content - Images -->
      <div class="flex-1 grid sm:grid-cols-3 gap-3 md:gap-6 lg:gap-8">
        <div v-for="item in newsItems" :key="item.id"
          class="relative h-133 sm:h-83 md:h-103 lg:h-133 xl:h-163 2xl:h-183 overflow-hidden">
          <img :src="item.imageUrl" alt="news" class="w-full h-full object-cover" />
          <p
            class="absolute bottom-3 lg:bottom-6 xl:bottom-11 z-2 text-white p-4 text-base sm:text-xs lg:text-sm xl:text-base 2xl:text-lg lg:leading-5.5 font-light">
            {{ item.description }}
          </p>
          <div class="absolute inset-x-0 bottom-0 z-1 h-50 bg-gradient-to-t from-black/70 to-transparent"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
import { ref } from 'vue';

const newsItems = ref([
  {
    id: 1,
    imageUrl: '/img/news/1.jpg',
    description: trans('news.item1'),
  },
  {
    id: 2,
    imageUrl: '/img/news/2.jpg',
    description: trans('news.item2'),
  },
  {
    id: 3,
    imageUrl: '/img/news/3.jpg',
    description: trans('news.item3'),
  },
]);
</script>


