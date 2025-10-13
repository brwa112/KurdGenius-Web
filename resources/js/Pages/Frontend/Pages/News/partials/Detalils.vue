<template>
  <section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- News Header -->
        <div class="p-8">
          <div class="text-sm text-gray-600 mb-4">
            {{ $t('newsDetails.sampleDate') }} | {{ $t('newsDetails.sampleLocation') }}
          </div>
          <div class="text-primary text-sm mb-4">
            {{ $t('newsDetails.sampleHashtag') }}
          </div>
          
          <!-- News Title -->
          <h1 class="text-3xl font-bold text-gray-900 mb-6">
            {{ $t('newsDetails.sampleTitle') }}
          </h1>
          
          <button class="text-primary hover:underline">
            {{ $t('newsDetails.readMore') }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';
</script>
