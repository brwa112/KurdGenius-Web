<template>
  <section class="relative">
    <!-- Hero -->
    <div class="relative min-h-dvh flex items-end">
      <!-- Background Image -->
      <div class="absolute inset-0">
        <img :src="'./img/home/hero-bg.jpg'" alt="Hero Background" class="w-full h-full object-cover object-top" />
        <!-- Overlay -->
        <div class="absolute inset-0 bg-f-primary opacity-20"></div>
      </div>

      <!-- Content -->
      <div class="relative z-10 w-full sm:container 2xl:max-w-[85%] mx-auto px-4 pb-8">
        <div class="w-full flex flex-col lg:flex-row lg:items-end justify-between gap-6 sm:gap-12">
          <!-- Left Content -->
          <h1 class="text-white text-4xl md:text-5xl lg:text-6xl 2xl:text-[64px] font-bold mb-6 leading-tight">
            {{ $t('frontend.hero.title') }}
          </h1>

          <!-- Right Content - Info Card -->
          <div class="text-white space-y-3">
            <div
              class="bg-f-primary p-5 text-white flex flex-col justify-between space-y-3 w-full lg:min-w-[130px] min-h-[40px]">
              <div class="bg-white w-[35px] h-1.5 rounded-full"></div>
              <div class="space-y-1">
                <h2 class="text-xl sm:text-2xl font-semibold">{{ $t('frontend.hero.subtitle_one') }}</h2>
                <h2 class="text-xl sm:text-2xl font-semibold">{{ $t('frontend.hero.subtitle_two') }}</h2>
              </div>
            </div>
            <button
              class="bg-black text-white flex flex-col items-center justify-center lowercase px-3 min-w-[100px] h-[40px] font-normal mb-8">
              <span>{{ $t('frontend.common.see_more') }}</span>
              <div class="block">
                <Svg name="arrow_down" class="size-5 animate-bounce"></Svg>
              </div>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Statistics Bar at Bottom -->
    <div class="bg-f-primary py-[3.375rem]" ref="statisticsSection">
      <div class="sm:container 3xl:max-w-[85%] mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 items-center justify-center gap-8 text-white">
          <div class="flex flex-col items-center text-center sm:text-start">
            <div class="block">
              <div class="text-3xl font-semibold mb-0.5">
                <AnimatedNumber dir="ltr" :number="expertTutors" />
              </div>
              <h1 class="text-xl font-light">{{ $t('frontend.stats.expert_tutors') }}</h1>
            </div>
          </div>
          <div class="flex flex-col items-center text-center sm:text-start">
            <div class="block">
              <div class="text-3xl font-semibold mb-0.5">
                <AnimatedNumber dir="ltr" :number="students" />
              </div>
              <h1 class="text-xl font-light">{{ $t('frontend.stats.students') }}</h1>
            </div>
          </div>
          <div class="flex flex-col items-center text-center sm:text-start">
            <div class="block">
              <div class="text-3xl font-semibold mb-0.5 flex items-center">
                <AnimatedNumber dir="ltr" :number="experience" />
                <span class="">+ {{ $t('frontend.stats.years') }}</span>
              </div>
              <h1 class="text-xl font-light">{{ $t('frontend.stats.experience') }}</h1>
            </div>
          </div>
          <div class="flex flex-col items-center text-center sm:text-start">
            <div class="block">
              <div class="text-3xl font-semibold mb-0.5">
                <AnimatedNumber dir="ltr" :number="campuses" />
              </div>
              <h1 class="text-xl font-light">{{ $t('frontend.stats.campuses') }}</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
import { onMounted, ref, onUnmounted } from 'vue';
import AnimatedNumber from '@/Pages/Frontend/Components/AnimatedNumber.vue';

const expertTutors = ref(0);
const students = ref(0);
const experience = ref(0);
const campuses = ref(0);

const statisticsSection = ref(null);
let observer = null;

const startAnimation = () => {
  expertTutors.value = 23;
  students.value = 352;
  experience.value = 6;
  campuses.value = 3;
};

onMounted(() => {
  // Create intersection observer to watch when statistics section comes into view
  observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Start animation when section is visible
          startAnimation();
          // Stop observing after animation starts
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.5, // Trigger when 50% of the section is visible
      rootMargin: '-50px' // Start animation 50px before the section is fully visible
    }
  );

  // Start observing the statistics section
  if (statisticsSection.value) {
    observer.observe(statisticsSection.value);
  }
});

onUnmounted(() => {
  // Clean up observer when component is unmounted
  if (observer) {
    observer.disconnect();
  }
});
</script>
