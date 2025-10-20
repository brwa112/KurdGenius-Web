<template>
    <div>

        <Head>
            <title>Login</title>
        </Head>

        <div class="absolute inset-0">
            <img :src="'/assets/images/auth/bg-gradient.png'" alt="image" class="h-full w-full object-cover" />
        </div>
        <div
            class="relative flex min-h-dvh items-center justify-center bg-[url(/assets/images/auth/map.png)] bg-cover bg-center bg-no-repeat px-3 py-10 dark:bg-[#060818]">
            <img :src="'/assets/images/auth/coming-soon-object1.png'" alt="image"
                class="absolute left-0 top-1/2 h-full max-h-[893px] -translate-y-1/2" />
            <img :src="'/assets/images/auth/coming-soon-object2.png'" alt="image"
                class="absolute left-24 top-0 h-40 md:left-[30%]" />
            <img :src="'/assets/images/auth/coming-soon-object3.png'" alt="image"
                class="absolute right-0 top-0 h-[300px]" />
            <img :src="'/assets/images/auth/polygon-object.svg'" alt="image" class="absolute bottom-0 end-[28%]" />
            <div
                class="relative flex w-full max-w-xl flex-col justify-between overflow-hidden rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50">
                <div class="relative flex w-full flex-col items-center justify-center gap-6 px-5 pb-16 pt-6 sm:px-6">
                    <div class="relative flex items-center gap-2 w-full max-w-[440px]">
                        <div class="w-8 block lg:block">
                            <!-- <img :src="'/assets/images/safelogo.png'" alt="Logo" class="mx-auto w-10" /> -->
                            <div class="main-logo flex items-center whitespace-nowrap">
                                <img class="w-8 ml-[5px] flex-none" :src="'/img/logo/full_logo.png'" alt="" />
                                <h1
                                    class="b-text-xl ms-2 font-bold align-middle uppercase inline text-gray-600 dark:text-white-light">
                                    {{ $t('common.logo') }}
                                </h1>
                            </div>
                        </div>
                        <!-- <div class="dropdown ms-auto w-max">
                            <Popper :placement="dir === 'rtl' ? 'bottom-end' : 'bottom-start'" offsetDistance="8"
                                class="align-middle">
                                <button type="button"
                                    class="block p-2 rounded-full bg-white-light dark:bg-dark/40 hover:text-primary hover:bg-white-light/90 dark:hover:bg-dark/60">
                                    <img :src="`/assets/images/langs/${lang}.png`" alt="flag"
                                        class="w-5 h-5 object-cover rounded-full" />
                                </button>
                                <template #content="{ close }">
                                    <ul
                                        class="!px-2 !mt-2 text-dark dark:text-gray-200 grid grid-cols-1 gap-1 font-semibold dark:text-white-light/90 w-96 max-w-40">
                                        <template v-for="item in languages" :key="item.code">
                                            <li>
                                                <button type="button" class="w-full hover:text-primary"
                                                    :class="{ '!bg-primary/10 !text-primary': lang === item.code }"
                                                    @click="toggleDirection(item.code == 'en' ? 'ltr' : 'rtl', item.code), close()">
                                                    <img class="w-5 h-5 object-cover rounded-full"
                                                        :src="`/assets/images/langs/${item.code}.png`" />
                                                    <span class="ltr:ml-3 rtl:mr-3 capitalize">
                                                        {{ $t(`common.` + item.name) }}
                                                    </span>
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </template>
                            </Popper>
                        </div> -->
                    </div>
                    <div class="w-full max-w-[440px]">
                        <div class="mb-10">
                            <h1 class="b-text-xl md:b-text-2xl font-extrabold uppercase !leading-snug text-primary">
                                {{ $t('auth.sign_in') }}
                            </h1>
                            <p class="b-text-xs md:b-text-base font-bold leading-normal text-white-dark">
                                {{ $t('auth.detail_sign_in') }}
                            </p>

                            <!-- error -->
                            <p v-if="errors.length" class="text-red-500 b-text-sm mt-2">
                                {{ errors }}
                            </p>

                        </div>
                        <form @submit.prevent="login" class="space-y-5 dark:text-white">
                            <div>
                                <label for="login">{{ $t('auth.email_or_phone') }}</label>
                                <div dir="ltr" class="relative text-white-dark">
                                    <input id="login" type="login" :placeholder="$t('auth.email_or_phone')"
                                        v-model="form.login" class="form-input ps-10 placeholder:text-white-dark" />
                                    <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                        <Svg name="user" class="size-5"></Svg>
                                    </span>
                                </div>
                                <p class="b-text-sm text-red-500 m-1">{{ form.errors.login }}</p>
                            </div>
                            <div>
                                <label for="Password">{{ $t('auth.password') }}</label>
                                <div dir="ltr" class="relative text-white-dark">
                                    <input id="Password" :placeholder="$t('common.enter') + ' ' + $t('auth.password')"
                                        :type="passwordView" v-model="form.password"
                                        class="form-input ps-10 placeholder:text-white-dark" />
                                    <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                        <Svg name="lock" class="size-4.5"></Svg>
                                    </span>
                                    <button type="button" @click="passwordToggle" v-if="passwordView === 'password'"
                                        class="absolute inset-y-0 end-5 z-20 cursor-pointer">

                                        <Svg name="eye_line" class="size-5"></Svg>
                                    </button>
                                    <button type="button" @click="passwordToggle" v-else
                                        class="absolute inset-y-0 end-5 z-20 cursor-pointer">
                                        <Svg name="eye" class="size-5 "></Svg>
                                    </button>
                                </div>
                                <p class="b-text-sm text-red-500 m-1">{{ form.errors.password }}</p>
                            </div>
                            <button type="submit" :disabled="form.processing"
                                class="btn btn-primary !mt-6 w-full border-0 uppercase">
                                {{ $t('auth.login') }}
                            </button>
                        </form>
                    </div>
                    <p dir="ltr" class="absolute bottom-6 w-full text-center dark:text-white">
                        © {{ new Date().getFullYear() }}.
                        <a href="https://safedatait.com" class="font-medium hover:underline" target="_blank">
                            SafeData Co.
                        </a>
                        {{ $t('nav.all_reserved') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { useForm, Head } from '@inertiajs/vue3'
import { loadLanguageAsync } from 'laravel-vue-i18n';
import { getDefaultSettings } from '@/settings.js';
import 'vue3-carousel/dist/carousel.css'
import { usePage } from '@inertiajs/vue3';


const settings = getDefaultSettings()
const emits = defineEmits();

const page = usePage()

const form = useForm({
    login: '',
    password: '',
});

const errors = ref(form.errors)

const login = () => {
    form.post(route('auth.login'), {
        onSuccess: () => {
            form.reset()
        },
        onError: (e) => {
            errors.value = e
            console.log(errors.value)
        }
    })
}

const passwordView = ref('password')

const passwordToggle = () => {
    passwordView.value = passwordView.value === 'password' ? 'text' : 'password'
}

// const dir = inject('rtlClass')
// const lang = ref(localStorage.getItem('lang') || 'en')

// Get languages from Inertia page props instead of settings
// const pageLanguages = page.props.languages || {
//     'en': 'English',
//     'ku': 'Kurdish',
//     'ar': 'Arabic',
//     'fr': 'French'
// }

// Convert the languages object to array format expected by the component
// const languages = ref(Object.keys(pageLanguages).map(code => ({
//     code: code,
//     name: pageLanguages[code].toLowerCase()
// })))

// const currentLang = ref(languages.value.find((item) => item.code === lang.value))

// const toggleDirection = (direction, language) => {
//     dir.value = direction
//     settings.toggleDir(direction)
//     lang.value = lang.value
//     settings.changeLanguage(language)
//     currentLang.value = language;
//     loadLanguageAsync(language)
// }

// const theme = ref(inject('theme'))
// const toggleTheme = () => {
//     theme.value = theme.value === 'light' ? 'dark' : 'light';
//     settings.toggleTheme(theme.value);
//     emits('checkSettings');
// };

</script>

<script>
import layout from '@/Layouts/Public.vue'

export default {
    layout: layout,
}
</script>