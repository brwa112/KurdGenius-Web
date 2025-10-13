<template>
  <section class="w-full sm:container 3xl:max-w-[85%] mx-auto px-4 mt-15">
    <div class="flex flex-col gap-10 xl:gap-8 py-3 md:py-8 lg:py-16">
      <!-- Top Content -->
      <div class="flex-1 flex flex-col md:flex-row justify-between gap-2">
        <div class="flex-1 space-y-1.5">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ $t('classrooms.title') }}
          </h2>
          <p
            class="leading-6 text-base lg:text-lg xl:text-xl font-normal text-pretty max-w-md lg:max-w-xl xl:max-w-2xl">
            {{ $t('classrooms.description') }}
          </p>
        </div>
        <div class="md:mx-4 mt-4">
          <a href="#" class="font-normal">
            <span>{{ $t('common.seeMore') }}</span>
            <div class="w-10 h-0.5 bg-yellow-400 rounded-full"></div>
          </a>
        </div>
      </div>

      <!-- List -->
      <div class="relative">
        <swiper ref="swiperRef" v-bind="swiperSettings" @swiper="onSwiper($event)" @slideChange="onSlideChange($event)">
          <swiper-slide v-for="(cumpus, slideIndex) in classItems" :key="slideIndex" :class="[
            { '!w-82.5 2xs:!w-100.5 lg:!w-123 xl:!w-167': slideIndex === 2 },
            { '!w-45 lg:!w-50 xl:!w-67': slideIndex != 2 },
          ]">
            <div
              class="relative h-113 sm:h-93 lg:h-123 xl:h-153 2xl:h-160 rounded-4xl lg:rounded-[60px] overflow-hidden">
              <img :src="cumpus.imageUrl" alt="news" class="w-full h-full object-cover" />
              <div :class="{ 'hidden': slideIndex != 2 }"
                class="absolute inset-x-5 bottom-5 bg-white text-black py-5 px-7 lg:py-8 lg:px-10 rounded-4xl lg:rounded-[60px] text-justify duration-500">
                <h3 class="text-base lg:text-xl font-medium mb-1 lg:mb-3">{{ $t(cumpus.titleKey || cumpus.title) }}</h3>
                <p class="text-xs lg:text-base font-light leading-5">
                  {{ $t(cumpus.descriptionKey || cumpus.description) }}
                </p>
              </div>
              <div v-if="slideIndex === 2"
                class="absolute end-3 2xl:end-5 top-14 2xl:top-18 z-5 -translate-y-1/2 h-full flex items-center">
                <button type="button"
                  class="relative z-10 flex size-10 xl:size-14 2xl:size-15 rounded-full bg-white items-center justify-center duration-750">
                  <Svg name="arrow_top" class="relative z-10 h-8 xl:h-12 rtl:-rotate-90"></Svg>
                </button>
              </div>
            </div>
          </swiper-slide>
        </swiper>

        <!-- Custom Navigation -->
        <div
          class="absolute start-0 sm:-start-2 lg:-start-3 3xl:-start-8 top-1/2 z-5 -translate-y-1/2 h-full flex items-center">
          <button @click="slidePrev()" :class="{ '!bg-gray-100 !text-gray-700 pointer-events-none': isBeginning }"
            class="relative z-10 flex size-10.5 xl:size-14.5 2xl:size-16 rounded-full text-white bg-primary items-center justify-center duration-750">
            <Svg name="arrow-up-light" class="relative z-10 h-5.5 xl:h-8.5 ltr:rotate-180"></Svg>
          </button>
        </div>
        <div
          class="absolute end-0 sm:-end-2 lg:-end-3 3xl:-end-3 top-1/2 z-5 -translate-y-1/2 h-full flex items-center">
          <button @click="slideNext()" :class="{ '!bg-gray-100 !text-gray-700 pointer-events-none': isEnd }"
            class="relative z-10 flex size-10.5 xl:size-14.5 2xl:size-16 rounded-full text-white bg-primary items-center justify-center duration-750">
            <Svg name="arrow-up-light" class="relative z-10 h-5.5 xl:h-8.5 rtl:rotate-180"></Svg>
          </button>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
import { computed, ref } from 'vue';

const classItems = ref([
  {
    id: 1,
    imageUrl: '/img/class/1.jpg',
    titleKey: 'class.item1.title',
    descriptionKey: 'class.item1.description',
  },
  {
    id: 2,
    imageUrl: '/img/class/2.jpg',
    titleKey: 'class.item2.title',
    descriptionKey: 'class.item2.description',
  },
  {
    id: 3,
    imageUrl: '/img/class/3.jpg',
    titleKey: 'class.item3.title',
    descriptionKey: 'class.item3.description',
  },
  {
    id: 4,
    imageUrl: '/img/class/4.jpg',
    titleKey: 'class.item4.title',
    descriptionKey: 'class.item4.description',
  },
  {
    id: 5,
    imageUrl: '/img/class/5.jpg',
    titleKey: 'class.item5.title',
    descriptionKey: 'class.item5.description',
  },
  {
    id: 6,
    imageUrl: '/img/class/6.jpg',
    titleKey: 'class.item6.title',
    descriptionKey: 'class.item6.description',
  },
  {
    id: 7,
    imageUrl: '/img/class/7.jpg',
    titleKey: 'class.item7.title',
    descriptionKey: 'class.item7.description',
  }
]);

const swiperSettings = computed(() => ({
  slidesPerView: 'auto',
  spaceBetween: 35,
  loop: false,
  direction: 'horizontal',
  speed: 600,
  breakpoints: {
    340: {
      spaceBetween: 20,
    },
    768: {
      spaceBetween: 20,
    },
    1024: {
      spaceBetween: 20,
    },
    1280: {
      spaceBetween: 32,
    },
  },
}))

const swiperInstance = ref(null)
const isEnd = ref(false)
const isBeginning = ref(true)

const onSwiper = (swiper) => {
  swiperInstance.value = swiper
  isEnd.value = swiper.isEnd
  isBeginning.value = swiper.isBeginning
}

const onSlideChange = (swiper) => {
  isEnd.value = swiper.isEnd
  isBeginning.value = swiper.isBeginning
}

const slideNext = () => {
  swiperInstance.value?.slideNext()
  isEnd.value = swiperInstance.value?.isEnd
  isBeginning.value = swiperInstance.value?.isBeginning
}

const slidePrev = () => {
  swiperInstance.value?.slidePrev()
  isEnd.value = swiperInstance.value?.isEnd
  isBeginning.value = swiperInstance.value?.isBeginning
}
</script>

<style scoped>
.swiper {
  overflow: visible !important;
}

.swiper-wrapper {
  height: auto !important;
}

.swiper-slide {
  height: auto !important;
  width: auto !important;
}
</style>

