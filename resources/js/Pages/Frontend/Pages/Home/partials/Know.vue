<template>
  <section v-if="shouldDisplay" class="w-full sm:container 3xl:max-w-[70%] mx-auto px-4">
    <div class="flex flex-col gap-10 xl:gap-16 py-12 lg:py-20">
      <div class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl">
        <span>{{ $t('frontend.know_more.title') }}</span>
        <div class="w-[88px] h-1 bg-yellow-400 rounded-full ltr:mt-1.5 rtl:mt-6"></div>
        <div class="flex items-center gap-2 mt-6">
          <a v-if="youtubeUrl" :href="youtubeUrl" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
            <Svg name="logos_youtube" class="h-[30px]"></Svg>
          </a>
          <a v-if="facebookUrl" :href="facebookUrl" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <Svg name="facebook_fill" class="h-10 text-[#1877F2]"></Svg>
          </a>
          <a v-if="instagramUrl" :href="instagramUrl" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <Svg name="instagram" class="h-8"></Svg>
          </a>
          <a v-if="twitterUrl" :href="twitterUrl" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
            <Svg name="twitter" class="h-8 ms-1"></Svg>
          </a>
          
          <!-- Fallback links if no data -->
          <template v-if="!hasAnyLinks">
            <a href="#" aria-label="YouTube">
              <Svg name="logos_youtube" class="h-[30px]"></Svg>
            </a>
            <a href="#" aria-label="Facebook">
              <Svg name="facebook_fill" class="h-10 text-[#1877F2]"></Svg>
            </a>
            <a href="#" aria-label="Instagram">
              <Svg name="instagram" class="h-8"></Svg>
            </a>
            <a href="#" aria-label="Twitter">
              <Svg name="twitter" class="h-8 ms-1"></Svg>
            </a>
          </template>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue';

// Define props
const props = defineProps({
  data: {
    type: Object,
    default: null
  }
});

// Computed properties for social links
const youtubeUrl = computed(() => {
  return props.data?.metadata?.youtube || null;
});

const facebookUrl = computed(() => {
  return props.data?.metadata?.facebook || null;
});

const instagramUrl = computed(() => {
  return props.data?.metadata?.instagram || null;
});

const twitterUrl = computed(() => {
  return props.data?.metadata?.twitter || null;
});

const hasAnyLinks = computed(() => {
  return youtubeUrl.value || facebookUrl.value || instagramUrl.value || twitterUrl.value;
});

const shouldDisplay = computed(() => {
  // Show if data exists and is active, or always show for fallback
  return !props.data || props.data?.is_active !== false;
});
</script>
