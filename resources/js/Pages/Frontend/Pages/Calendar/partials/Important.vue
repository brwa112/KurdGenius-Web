<template>
  <section class="w-full sm:container 3xl:max-w-[70%] mx-auto px-4 mb-15 lg:mb-15">
    <div class="relative flex flex-col items-start gap-y-5 gap-x-8 xl:gap-x-10 pb-10 md:pb-26 pt-8">
      <!-- Left Content -->
      <div class="relative z-5 flex-1 space-y-1.5 max-w-xl xl:max-w-2xl text-justify">
        <h2 class="relative z-10 text-2xl lg:text-3xl xl:text-[32px] font-semibold text-black leading-tight">
          {{ $t('calendar.importantTitle') }}
        </h2>
        <img :src="'/img/shape_red.svg'" alt="ShapeOne" class="absolute -top-5 -start-5 3xl:-start-15 opacity-20 3xl:opacity-100" />
      </div>

      <!-- Table -->
      <div class="w-full overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full border-collapse border border-gray-300 font-medium">
            <tbody>
              <tr class="border-b border-gray-300">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.startSchool.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.startSchool.date') }}
                </td>
              </tr>
              <tr class="border-b border-gray-300">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.midterm.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.midterm.date') }}
                </td>
              </tr>
              <tr class="border-b border-gray-300">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.finals.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.finals.date') }}
                </td>
              </tr>
              <tr class="border-b border-gray-300">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.parentMeeting.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.parentMeeting.date') }}
                </td>
              </tr>
              <tr class="border-b border-gray-300">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.scienceFair.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.scienceFair.date') }}
                </td>
              </tr>
              <tr class="border-b border-gray-300">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.graduation.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.graduation.date') }}
                </td>
              </tr>
              <tr class="">
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl lg:w-2/3">
                  {{ $t('calendar.dates.summer.event') }}
                </td>
                <td class="px-4 sm:px-6 py-3.5 sm:py-4.5 text-sm sm:text-base lg:text-xl border-s border-gray-300">
                  {{ $t('calendar.dates.summer.date') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>

