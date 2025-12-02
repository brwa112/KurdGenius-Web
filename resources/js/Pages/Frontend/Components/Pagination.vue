<template>
  <div class="mt-16 flex justify-center gap-2" v-if="pagination && pagination.last_page > 1">
    <!-- Previous Button -->
    <button @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" :class="[
      'size-9 flex items-center justify-center border border-black rounded-full duration-300',
      pagination.current_page === 1
        ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
        : 'bg-white text-black hover:text-white hover:bg-black'
    ]">
      <Svg name="arrow_right" class="size-6 ltr:rotate-180"></Svg>
    </button>

    <!-- Page Numbers -->
    <div class="flex justify-center gap-1">
      <button v-for="(page, index) in pageNumbers" :key="index" @click="page !== '...' && goToPage(page)"
        :disabled="page === '...'" :class="[
          'size-9 border border-black rounded-full duration-300',
          page === pagination.current_page
            ? 'bg-black text-white'
            : page === '...'
              ? 'bg-white text-black cursor-default'
              : 'bg-white text-black hover:text-white hover:bg-black'
        ]">
        {{ page }}
      </button>
    </div>

    <!-- Next Button -->
    <button @click="goToPage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page"
      :class="[
        'size-9 flex items-center justify-center border border-black rounded-full duration-300',
        pagination.current_page === pagination.last_page
          ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
          : 'bg-white text-black hover:text-white hover:bg-black'
      ]">
      <Svg name="arrow_right" class="size-6 rtl:rotate-180"></Svg>
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  pagination: {
    type: Object,
    required: true,
    validator: (value) => {
      return value &&
        typeof value.current_page === 'number' &&
        typeof value.last_page === 'number'
    }
  },
  preserveScroll: {
    type: Boolean,
    default: true
  },
  preserveState: {
    type: Boolean,
    default: true
  },
  scrollToTop: {
    type: Boolean,
    default: false
  },
  clientSide: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['page-changed'])

// Navigate to page
const goToPage = (page) => {
  if (page < 1 || page > props.pagination.last_page) return

  // Emit event for page change
  emit('page-changed', page)

  // Only use router if not in client-side mode
  if (!props.clientSide) {
    // Scroll to top if requested
    if (props.scrollToTop) {
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }

    router.visit(window.location.pathname, {
      data: { page },
      preserveState: props.preserveState,
      preserveScroll: props.preserveScroll,
    })
  } else if (props.scrollToTop) {
    // Client-side mode: just scroll to top if requested
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

// Generate page numbers to display
const pageNumbers = computed(() => {
  if (!props.pagination) return []

  const current = props.pagination.current_page
  const last = props.pagination.last_page
  const pages = []

  // If total pages <= 7, show all pages
  if (last <= 7) {
    for (let i = 1; i <= last; i++) {
      pages.push(i)
    }
    return pages
  }

  // Always show first page
  pages.push(1)

  // Show pages around current page
  if (current > 3) {
    pages.push('...')
  }

  // Calculate range around current page
  const start = Math.max(2, current - 1)
  const end = Math.min(last - 1, current + 1)

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  // Show last page if not already shown
  if (current < last - 2) {
    pages.push('...')
  }

  if (last > 1) {
    pages.push(last)
  }

  return pages
})
</script>
