<script setup>
import {defineProps} from 'vue';
import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from '@headlessui/vue';
import {SelectorIcon} from '@heroicons/vue/solid';


const props = defineProps({
    items: {
        type: Array,
    },
    selectedItem: {
        type: Object,
    },
    noItemSelectedText: {
        type: String,
        default: "Selecteer een optie"
    },
    label: {
        type: String,
    }
});
</script>


<template>
    <Listbox as="div" v-model="selectedItem">
        <ListboxLabel class="block text-sm font-medium text-gray-700">{{ label }}</ListboxLabel>
        <div class="mt-1 relative">
            <ListboxButton
                class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <span class="flex items-center">
            <span v-if="selectedItem == null">{{ noItemSelectedText }}</span>
            <slot v-if="selectedItem != null" v-bind="selectedItem"></slot>
        </span>
                <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          <SelectorIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
        </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                <ListboxOptions
                    class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="item in items" :key="item.id" :value="item"
                                   v-slot="{ active, selected }">
                        <li :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                            <slot v-bind="item"></slot>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
