<template>
  <section class="mt-15 mb-15 xl:mt-30 lg:mb-15">
    <div class="w-full sm:container 3xl:max-w-[85%] mx-auto px-4">
      <div class="relative flex flex-col lg:flex-row items-center justify-between gap-y-14 gap-x-8 xl:gap-x-10 py-16">
        <!-- Left Content -->
        <div class="relative z-5 flex-1 space-y-1.5 max-w-xl xl:max-w-2xl text-justify">
          <h2 class="text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
            {{ $t('about.title') }}
          </h2>
          <p class="leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty">
            {{ $t('about.paragraph1') }}
          </p>
          <p class="leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty mt-5">
            {{ $t('about.paragraph2') }}
          </p>
          <p class="leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty mt-5">
            {{ $t('about.paragraph3') }}
          </p>
          <p class="leading-6 text-base lg:text-base xl:text-xl font-normal text-pretty mt-5">
            {{ $t('about.paragraph4') }}
          </p>
        </div>

        <!-- Right Content - Images -->
        <div class="relative pe-10 sm:pe-20 2xl:pe-34">
          <div class="relative z-2 size-72 sm:size-108 xl:size-128">
            <img :src="'/img/about/1.jpg'" alt="mission" class="w-full h-full object-cover" />
          </div>
          <div class="absolute top-5 start-5 z-1 bg-[#5977FE] size-72 sm:size-108 xl:size-128"></div>
          <div class="absolute -top-5 sm:-top-10 start-14 sm:start-21 z-3">
            <img :src="'/img/about/scribble.svg'" alt="mission" class="size-1/2 sm:size-full object-cover" />
          </div>
          <div class="absolute top-1/2 -end-20 sm:-end-8 2xl:end-0 z-3">
            <img :src="'/img/about/ruler.svg'" alt="mission" class="size-1/2 sm:size-full object-cover" />
          </div>
          <div class="absolute -bottom-7 sm:-bottom-14 start-20 sm:start-30 z-3">
            <img :src="'/img/about/shape-yellow.svg'" alt="mission" class="size-1/2 sm:size-full object-cover" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>
