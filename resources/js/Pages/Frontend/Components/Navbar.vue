<template>

  <nav class="fixed top-0 inset-x-0 z-50 bg-white shadow-md">

    <!-- Top bar -->
    <div class="bg-primary text-white py-4 px-4 hidden xl:block">
      <div class="max-w-[85%] 3xl:max-w-[70%] mx-auto flex justify-between items-center gap-2 text-sm">
        <!-- Mobile: Show only phone number -->
        <div class="flex items-center gap-4 md:gap-6">
          <div class="flex items-center gap-1">
            <Svg name="call_fill" class="size-5"></Svg>
            <span dir="ltr" class="opacity-80 text-xs md:text-sm">{{ trans('contact.phone') }}</span>
          </div>
          <div class="flex items-center gap-1">
            <Svg name="email_fill" class="size-5"></Svg>
            <span class="opacity-80">{{ trans('contact.email') }}</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <a href="#" class="hover:text-primary-200 transition-colors">
            <Svg name="facebook_fill" class="size-5"></Svg>
          </a>
          <a href="#" class="hover:text-primary-200 transition-colors">
            <Svg name="instagram_fill" class="size-5"></Svg>
          </a>
        </div>
      </div>
    </div>

    <!-- Main navigation -->
    <div class="sm:container 3xl:max-w-[85%] mx-auto px-4 py-2 flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center space-x-2 md:space-x-3">
        <img :src="'/img/logo.png'" alt="Kurd Genius Schools Logo" class="size-12 md:size-15 object-contain" />
        <div class="text-sm md:text-base font-bold hidden 2xl:block">{{ trans('nav.schoolName') }}</div>
        <div class="text-xl font-bold block 2xl:hidden">{{ trans('nav.schoolAbbr') }}</div>
      </div>

      <!-- Desktop Navigation Menu -->
      <div class="hidden xl:flex items-center space-x-8">
        <Link :href="route('index')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'index' }">
          {{ trans('nav.home') }}
        </Link>
        <!-- <Link :href="route('about')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'about' }">
          {{ trans('nav.about') }}
        </Link>
        <Link :href="route('campus')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'campus' }">
          {{ trans('nav.campus') }}
        </Link>
        <Link :href="route('calendar')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'calendar' }">
          {{ trans('nav.calendar') }}
        </Link>
        <Link :href="route('academic')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'academic' }">
          {{ trans('nav.academics') }}
        </Link>
        <Link :href="route('admission')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'admission' }">
          {{ trans('nav.admission') }}
        </Link>
        <Link :href="route('news')" class="hover:text-primary font-medium transition-colors"
          :class="{ 'font-semibold text-primary': currentRoute === 'news' }">
          {{ trans('nav.news') }}
        </Link> -->
      </div>

      <!-- Desktop Right side controls -->
      <div class="flex items-center space-x-3">
        <!-- Branches dropdown -->
        <Menu as="div" class="relative">
          <MenuButton
            class="hover:text-primary-200 font-medium flex items-center space-x-1 transition-colors cursor-pointer">
            <Svg name="building_fill" class="size-5 text-black"></Svg>
            <span class="hidden sm:block">{{ trans('nav.branches') }}</span>
            <Svg name="arrow_down" class="size-4"></Svg>
          </MenuButton>

          <Transition enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0">
            <MenuItems
              class="absolute mt-2 w-72 bg-white shadow-lg rounded-md overflow-hidden z-50 end-1/2 sm:end-0 ltr:translate-x-1/2 ltr:sm:translate-x-0 rtl:-translate-x-1/2 rtl:sm:translate-x-0">
              <div class="py-1">
                <MenuItem v-for="branch in branches" :key="branch.id" :as="'button'" @click="selectBranch(branch)"
                  class="w-full text-left px-4 py-1.5 hover:bg-gray-100 transition-colors cursor-pointer">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-1.5 text-start">
                    <img :src="branch.logo" :alt="branch.name" class="size-5 object-contain" />
                    <span class="text-[10px] md:text-xs"
                      :class="{ 'font-semibold text-primary': selectedBranch.id === branch.id }">
                      {{ trans(branch.translationKey) }}
                    </span>
                  </div>
                  <span v-if="selectedBranch.id === branch.id" class="text-primary">
                    <Svg name="check" class="size-4"></Svg>
                  </span>
                </div>
                </MenuItem>
              </div>
            </MenuItems>
          </Transition>
        </Menu>

        <!-- Language selector -->
        <Menu as="div" class="relative">
          <MenuButton class="text-primary font-semibold flex items-center space-x-1 cursor-pointer">
            <span>{{ currentLanguage.nativeName }}</span>
            <Svg name="arrow_down" class="size-4"></Svg>
          </MenuButton>

          <Transition enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0">
            <MenuItems class="absolute mt-2 w-40 bg-white shadow-lg rounded-md overflow-hidden z-50 end-0">
              <div class="py-1">
                <MenuItem v-for="language in availableLanguages" :key="language.id" :as="'button'"
                  @click="selectLanguage(language)"
                  class="w-full text-left px-4 py-1.5 hover:bg-gray-100 transition-colors cursor-pointer">
                <div class="flex items-center justify-between">
                  <span :class="{ 'font-semibold text-primary': currentLanguage.id === language.id }">
                    {{ language.nativeName }}
                  </span>
                  <span v-if="currentLanguage.id === language.id" class="text-primary">
                    <Svg name="check" class="size-4"></Svg>
                  </span>
                </div>
                </MenuItem>
              </div>
            </MenuItems>
          </Transition>
        </Menu>

        <!-- Mobile menu button -->
        <button @click="toggleMobileMenu" class="block xl:hidden p-2 rounded-md hover:bg-gray-100 transition-colors">
          <Svg name="menu" class="size-6"></Svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <Transition enter-active-class="transition-opacity duration-200" enter-from-class="opacity-0"
      enter-to-class="opacity-100" leave-active-class="transition-opacity duration-200" leave-from-class="opacity-100"
      leave-to-class="opacity-0">
      <div v-if="isMobileMenuOpen" class="fixed inset-0 bg-black/50 z-40 xl:hidden" @click="closeMobileMenu">
      </div>
    </Transition>

    <!-- Mobile Menu Sidebar -->
    <Transition enter-active-class="transition-transform duration-300 ease-out"
      enter-from-class="transform ltr:translate-x-full rtl:-translate-x-full" enter-to-class="transform translate-x-0"
      leave-active-class="transition-transform duration-300 ease-in" leave-from-class="transform translate-x-0"
      leave-to-class="transform ltr:translate-x-full rtl:-translate-x-full">
      <div v-if="isMobileMenuOpen" class="fixed inset-y-0 end-0 w-80 max-w-[90vw] bg-white shadow-2xl z-50 xl:hidden">
        <div class="h-full flex flex-col">
          <!-- Mobile Menu Header -->
          <div class="flex items-center p-4 ltr:justify-end rtl:justify-start">
            <button @click="closeMobileMenu" class="p-2 rounded-md hover:bg-gray-100 transition-colors">
              <Svg name="close" class="size-5 text-black"></Svg>
            </button>
          </div>

          <!-- Mobile Menu Content -->
          <div class="flex flex-col h-full">
            <!-- Links -->
            <div class="w-full py-4 my-auto mx-auto text-center">
              <Link :href="route('index')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'index' }">
                {{ trans('nav.home') }}
              </Link>
              <!-- <Link :href="route('about')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'about' }">
                {{ trans('nav.about') }}
              </Link>
              <Link :href="route('campus')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'campus' }">
                {{ trans('nav.campus') }}
              </Link>
              <Link :href="route('calendar')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'calendar' }">
                {{ trans('nav.calendar') }}
              </Link>
              <Link :href="route('academic')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'academic' }">
                {{ trans('nav.academics') }}
              </Link>
              <Link :href="route('admission')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'admission' }">
                {{ trans('nav.admission') }}
              </Link>
              <Link :href="route('news')" @click="closeMobileMenu"
                class="w-full flex items-center justify-center px-6 py-5 text-xl text-gray-800 transition-colors"
                :class="{ 'font-semibold text-primary': currentRoute === 'news' }">
                {{ trans('nav.news') }}
              </Link> -->
            </div>
            <!-- Mobile Contact Info -->
            <div class="mt-auto">
              <div class="py-4">
                <div class="space-y-3 px-6">
                  <div class="flex items-center gap-3">
                    <Svg name="call_fill" class="size-5 text-primary"></Svg>
                    <span dir="ltr" class="text-sm text-gray-700">{{ trans('contact.phone') }}</span>
                  </div>
                  <div class="flex items-center gap-3">
                    <Svg name="email_fill" class="size-5 text-primary"></Svg>
                    <span class="text-sm text-gray-700">{{ trans('contact.email') }}</span>
                  </div>
                  <div class="flex items-center gap-4 pt-2">
                    <a href="#" class="text-primary hover:text-primary-600 transition-colors">
                      <Svg name="facebook_fill" class="size-6"></Svg>
                    </a>
                    <a href="#" class="text-primary hover:text-primary-600 transition-colors">
                      <Svg name="instagram_fill" class="size-6"></Svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

const page = usePage();
const currentRoute = computed(() => page.component);
const isMobileMenuOpen = ref(false);

// Language management
const availableLanguages = ref([
  { id: 1, code: 'en', nativeName: 'English' },
  { id: 2, code: 'ar', nativeName: 'العربية' },
  { id: 3, code: 'ckb', nativeName: 'کوردی' },
  { id: 4, code: 'ku', nativeName: 'Kurdî' }
]);

const currentLanguage = ref(
  availableLanguages.value.find(lang => 
    lang.code === (localStorage.getItem('language') || 'en')
  ) || availableLanguages.value[0]
);

const branches = ref([
  {
    id: 1,
    name: 'Kurd Genius Educational Communities',
    translationKey: 'branches.kurd_genius',
    logo: '/img/logo.png',
    color: '#0028DF'
  },
  {
    id: 2,
    name: 'Kurd Genius Educational Communities 2',
    translationKey: 'branches.kurd_genius_2',
    logo: '/img/logo.png',
    color: '#5200DF'
  },
  {
    id: 3,
    name: 'Kurd Genius Educational Communities Qaiwan Heights',
    translationKey: 'branches.kurd_genius_qaiwan',
    logo: '/img/logo.png',
    color: '#337B7C'
  },
  {
    id: 4,
    name: 'Smart Educational Communities',
    translationKey: 'branches.smart_educational',
    logo: '/img/logo.png',
    color: '#5D5466'
  },
]);
const selectedBranch = ref(branches.value[0]);

function selectBranch(b) {
  selectedBranch.value = b;
  // Set the primary color based on the selected branch
  document.documentElement.style.setProperty('--color-primary', b.color);
}

function selectLanguage(language) {
  currentLanguage.value = language;
  localStorage.setItem('language', language.code);
  // You might want to reload or update the page to reflect language change
  window.location.reload();
}

function toggleMobileMenu() {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
}

function closeMobileMenu() {
  isMobileMenuOpen.value = false;
}

// Initialize the primary color when component mounts
onMounted(() => {
  document.documentElement.style.setProperty('--color-primary', selectedBranch.value.color);
});
</script>

