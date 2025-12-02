<template>
  <section class="mt-24 xl:mt-44">
    <div class="w-full sm:container 3xl:max-w-[73%] mx-auto px-4">
      <div class="relative flex flex-col gap-3 md:gap-6 py-16 lg:py-24">
        <!-- Top Content -->
        <div class="relative z-5 flex-1 space-y-1.5 max-w-2xl">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black !leading-tight">
            {{ $t('frontend.academic.approach_title') }}
          </h2>
          <p class="!leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty">
            {{ description }}
          </p>
          <p class="!leading-10 text-base lg:text-base xl:text-xl font-medium text-pretty text-f-primary">
            {{ $t('frontend.academic.approach_highlight') }}
          </p>
          <img :src="'/img/academic/paintbrush.svg'" alt="mission"
            class="absolute -top-11 xl:-top-20 start-4 xl:start-6 size-10 xl:size-auto rtl:scale-x-[-1]" />
          <img :src="'/img/academic/ruler.svg'" alt="mission"
            class="absolute -top-20 xl:-top-36 -start-5 xl:-start-12 size-14 xl:size-auto rtl:scale-x-[-1]" />
          <img :src="'/img/academic/pencil.svg'" alt="mission"
            class="absolute -top-5 xl:-top-11 -start-8 xl:-start-14 size-7 xl:size-auto rtl:scale-x-[-1]" />
        </div>
        <!-- Bottom Content -->
        <div
          class="relative z-10 w-full flex flex-col gap-4 bg-[#FFA610] rounded-3xl md:rounded-[50px] px-4 md:px-7 lg:px-8 py-4 md:py-5">
          <div v-for="(feature, index) in features" :key="index"
            class="relative z-10 group w-full xl:w-[70%] 2xl:w-[62.5%] flex items-center gap-2 rounded-full bg-white px-3 md:px-4 py-2 md:py-4 2xl:py-5 lg:min-w-[280px]">
            <img :src="'/img/academic/circle.svg'" alt="mission"
              class="size-4 md:size-4.5 2xl:size-[22px] duration-500 rotate-0 group-hover:-rotate-[150deg]" />
            <h2 class="relative z-[5] text-xs md:text-base 2xl:text-xl !leading-4">
              {{ feature.title }}
            </h2>
          </div>
          <!-- Image -->
          <div class="absolute bottom-0 -end-[172px] 2xl:-end-[220px] z-0 hidden xl:block">
            <div class="h-full lg:h-[560px] 2xl:h-[700px] overflow-hidden">
              <img :src="'/img/academic/person.png'" alt="mission"
                class="size-[680px] 2xl:size-[880px] object-contain object-top ltr:scale-x-[-1]" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import helpers from '@/helpers';

const props = defineProps({
  approach: {
    type: Object,
    default: null
  }
});

const page = usePage();

// Get description from database or fallback to translation
const description = computed(() => {
  if (props.approach?.description) {
    return helpers.getTranslatedText(props.approach.description, page);
  }
  return page.props.locale === 'ckb' 
    ? 'ئێمە باوەڕمان بە پەروەردەکردنی ژینگەیەکی فێربوونە کە خوێندکاران بەشداربووی چالاکن لە پەروەردەکەیاندا. ڕێبازەکەمان دانایی نەریتی بە شێوازە پەروەردەیی مۆدێرنەکان تێکەڵ دەکات.'
    : 'We offer a holistic, student-centered educational experience that blends academic learning with personal development.';
});

// Get features from database or fallback to hardcoded list
const features = computed(() => {
  if (props.approach?.features) {
    const translatedFeatures = helpers.getTranslatedText(props.approach.features, page);
    // Check if it's an array
    if (Array.isArray(translatedFeatures)) {
      return translatedFeatures;
    }
  }
  
  // Fallback data
  return [
    { title: 'International standards adapted to local needs' },
    { title: 'English, Math, Science, and IT based on global benchmarks' },
    { title: 'Strong focus on Kurdish and Arabic to preserve identity' },
    { title: 'Technology-enhanced classrooms and practical teaching methods' },
    { title: 'Emphasis on collaboration, communication, and critical thinking' },
  ];
});
</script>
