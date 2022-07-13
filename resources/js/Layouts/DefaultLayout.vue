<template>
    <Disclosure as="nav" class="bg-white" v-slot="{ open }">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Open main menu</span>
                        <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto" src="../Assets/Images/logo.png" alt="Workflow" />
                        <img class="hidden lg:block h-8 w-auto" src="../Assets/Images/logo.png" alt="Workflow" />
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <NavLink v-for="item in navigation" :key="item.name" :href="item.href" :classes="[item.href === $page.url ? 'bg-gray-200' : 'bg-gray-100', 'hover:bg-gray-300 px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
                                <span>{{ item.name }}</span>
                            </NavLink>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <menu v-if="$page.props.auth.user" class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <BreezeDropdown align="right" width="48">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 text-black bg-gray-100 focus:bg-gray-300 hover:bg-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </BreezeDropdownLink>
                                </template>
                            </BreezeDropdown>
                        </div>
                    </menu>
                    <Menu v-if="!$page.props.auth.user" as="div" class="ml-3 relative">
                        <NavLink :href="route('login')" :classes="['/login' === $page.url ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']">
                            <span>Login</span>
                        </NavLink>
                    </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">

                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
    <slot></slot>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu } from '@headlessui/vue'
import { MenuIcon, XIcon } from '@heroicons/vue/outline'
import NavLink from "../Components/NavLink.vue";
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';

const navigation = [
    { name: 'Assemblages', href: '/assemblies', current: true },]
</script>
<style>
    body {
        background: #edf2f7;
    }
</style>
