<template>
    <div v-if="phone?.filter" dir="ltr" class="dropdown flex">
        <Popper :placement="rtlClass === 'rtl' ? 'bottom-end' : 'bottom-start'" offsetDistance="0" class="align-middle">
            <button tabindex="-1" type="button" @click="phoneFocus" class="bg-[#eee] whitespace-nowrap flex justify-center items-center gap-1 rounded-l-md px-5 py-2 font-semibold border ltr:border-r-0 rtl:border-l-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">
                <img :src="phone.icon" alt="Flag" class="flag-icon size-5 object-contain">
                <span>
                    {{ phone.code }}
                </span>
            </button>
            <template #content="{ close }">
                <ul class="whitespace-nowrap min-w-96 rounded-md !pb-0 !pt-2.5 border border-gray-200 dark:border-gray-800">
                    <li>
                        <div class="bg-white dark:bg-[#1b2e4b] p-1.5 fixed top-0 left-0 right-0 rounded-t-md border border-gray-200 dark:border-gray-800">
                            <input ref="focusInput" type="text" placeholder="Search..." v-model="phoneFilter" class="form-input rounded-none focus:border-gray-200 py-1.5 px-3" />
                        </div>
                    </li>
                    <li @click="close()" class="mt-8 max-h-72 min-w-72 overflow-auto">
                        <button type="button" v-for="(phoneOption, i) in phoneOptions" @click="close(), phone = phoneOption" class="flex items-center gap-3 p-1" :key="i" :class="{ 'bg-gray-100 dark:bg-gray-800': phoneOption.id === phone.id }">
                            <img :src="phoneOption.icon" alt="Flag" class="flag-icon size-5 object-contain">
                            {{ phoneOption.label }}
                        </button>
                    </li>
                    <li v-if="phoneOptions.length == 0" class="mt-3">
                        <div class="px-4 min-w-56">
                            {{ $t('crm.no_results_found') }}
                        </div>
                    </li>
                </ul>
            </template>
        </Popper>
        <input id="staticMask1" type="text" :placeholder="phone.filter" :value="phoneNumber" @input="changeValue($event.target.value)" class="form-input rounded-l-none" v-maska="checkMask()" />
        <!-- @input="changeValue($event.target.value)" class="form-input rounded-l-none" maxlFength="15" /> -->
    </div>
</template>

<script setup>
import { ref, computed, inject, onMounted, watch } from 'vue';

const props = defineProps(['modelValue']);
const rtlClass = 'ltr';

const phoneNumber = ref(props.modelValue);

const phones = ref([
    {
        id: 1,
        name: 'Iraq',
        code: '+964',
        icon: '/assets/images/flags/IQ.svg',
        filter: '+964(###)###-####',
    },
    {
        id: 2,
        name: 'UAE',
        code: '+971',
        icon: '/assets/images/flags/AE.svg',
        filter: '+971(###)###-####',
    },
    {
        id: 3,
        name: 'Turkey',
        code: '+90',
        icon: '/assets/images/flags/TR.svg',
        filter: '+90(###)###-####',
    },
    {
        id: 15,
        name: 'Iran',
        code: '+98',
        icon: '/assets/images/flags/IR.svg',
        filter: '+98(###)###-####',
    },
    {
        id: 4,
        name: 'Kuwait',
        code: '+965',
        icon: '/assets/images/flags/KW.svg',
        filter: '+965(###)###-####',
    },
    {
        id: 5,
        name: 'Saudi Arabia',
        code: '+966',
        icon: '/assets/images/flags/SA.svg',
        filter: '+966(###)###-####',
    },
    {
        id: 6,
        name: 'Qatar',
        code: '+974',
        icon: '/assets/images/flags/QA.svg',
        filter: '+974(###)###-####',
    },
    {
        id: 7,
        name: 'Bahrain',
        code: '+973',
        icon: '/assets/images/flags/BH.svg',
        filter: '+973(###)###-####',
    },
    {
        id: 8,
        name: 'Oman',
        code: '+968',
        icon: '/assets/images/flags/OM.svg',
        filter: '+968(###)###-####',
    },
    {
        id: 9,
        name: 'Jordan',
        code: '+962',
        icon: '/assets/images/flags/JO.svg',
        filter: '+962(###)###-####',
    },
    {
        id: 10,
        name: 'Lebanon',
        code: '+961',
        icon: '/assets/images/flags/LB.svg',
        filter: '+961(###)###-####',
    },
    {
        id: 11,
        name: 'Egypt',
        code: '+20',
        icon: '/assets/images/flags/EG.svg',
        filter: '+20(###)###-####',
    },
    {
        id: 12,
        name: 'Syria',
        code: '+963',
        icon: '/assets/images/flags/SY.svg',
        filter: '+963(###)###-####',
    },
    {
        id: 13,
        name: 'Yemen',
        code: '+967',
        icon: '/assets/images/flags/YE.svg',
        filter: '+967(###)###-####',
    },
    {
        id: 14,
        name: 'Palestine',
        code: '+970',
        icon: '/assets/images/flags/PS.svg',
        filter: '+970(###)###-####',
    },
    {
        id: 15,
        name: 'United States',
        code: '+1',
        icon: '/assets/images/flags/US.svg',
        filter: '+1(###)###-####',
    },
    {
        id: 17,
        name: 'United Kingdom',
        code: '+44',
        icon: '/assets/images/flags/GB.svg',
        filter: '+44(###)###-####',
    },
    {
        id: 16,
        name: 'Germany',
        code: '+49',
        icon: '/assets/images/flags/DE.svg',
        filter: '+49(###)###-####',
    },
    {
        id: 18,
        name: 'Sweden',
        code: '+46',
        icon: '/assets/images/flags/SE.svg',
        filter: '+46(###)###-####',
    },
    {
        id: 19,
        name: 'Norway',
        code: '+47',
        icon: '/assets/images/flags/NO.svg',
        filter: '+47(###)###-####',
    },
]);

const phoneOptions = computed(() => {
    return phones.value.filter((item) => {
        return item.name.toLowerCase().includes(phoneFilter.value.toLowerCase()) ||
            item.code.includes(phoneFilter.value);
    }).map((item) => {
        // console.log('item', item);
        return {
            ...item,
            label: `${item.code} - ${item.name}`,
            icon: item.icon,
            filter: item.filter,
            // filter: fixFilter(item.filter),
            // filter: item.code + item.filter.split('(')[1],
        };
    });
});

const checkMask = () => {
    // console.log('phone.value.filter', phone.value.filter);
    return phone.value.filter;
};

const phone = ref({});
// let phone = ref(null);

onMounted(() => {
    //     phone = ref(phones.value[0]);
    //     console.log(
    //         'phoneOptions.value',
    //         phoneOptions.value,
    //         props
    //     );
    //     // focusInput.value.focus();
    phone.value = phones.value[0];
    checkPhoneNumber(props.modelValue);
    // console.log('onMounted', props.modelValue);
});

watch(() => props.modelValue, (newValue, oldValue) => {
    // var newNumber = fixNumber(oldValue);
    // console.log('watch', newValue, oldValue);
    checkPhoneNumber(newValue);
    // phoneNumber.value = newValue;
    // console.log('watch', newValue, oldValue);
});

const fixNumber = (value) => {
    //  get startsWith phone code from value
    const phoneCode = phones.value.find((item) => {
        return value.startsWith(item.code);
    });

    // remove phone code from value
    if (phoneCode) {
        value = value.replace(phoneCode.code, '');
    }

    // i want get befor '('
    const filter = phone.value.filter.split('(')[0];

    return filter + value;
};

const checkPhoneNumber = (value) => {
    // check this phone number for phone code
    // console.log('checkPhoneNumber', value);
    const phoneCode = phones.value.find((item) => {
        // console.log('item', item, value.startsWith(item.code));
        return value?.startsWith(item.code);
    });

    // console.log('phoneCode', phoneCode, value);

    if (phoneCode) {
        phone.value = phoneCode;
        phoneNumber.value = value;
    }
};

const emits = defineEmits();

watch(phone, (newValue, oldValue) => {

    const phoneCode = phones.value.find((item) => {
        return phoneNumber.value?.startsWith(item.code);
    });

    // remove phone code from value
    if (phoneCode) {
        phoneNumber.value = phoneNumber.value.replace(phoneCode.code, '');
    }

    phoneNumber.value = newValue.code + phoneNumber.value;

    // console.log(phoneNumber.value);

    emits('update:modelValue', phoneNumber.value);
});

const changeValue = (phone) => {
    // i want remove '(' and ')' from phone number
    // phone = phone.replace('(', '').replace(')', '');
    // const number = fixNumber(phone);
    // console.log('changeValue', number);
    emits('update:modelValue', phone);
};

const phoneFilter = ref('');

const focusInput = ref(null);
const phoneFocus = () => {
    setTimeout(() => {
        focusInput.value.focus();
    }, 100);
};
</script>