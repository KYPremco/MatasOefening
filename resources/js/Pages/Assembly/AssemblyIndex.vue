<script setup>
import NavLink from "../../Components/NavLink.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    assemblies: Object,
});

const destroy = (id) => {
    Inertia.delete(route("assemblies.destroy", id));
};
</script>


<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="flex flex-col items-center mt-3 md:mt-6">
        <div class="w-full sm:max-w-4xl mt-6 ">
            <div
                v-if="$page.props.flash.message"
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert"
            >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
            </div>

            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-semibold text-gray-900">
                                    <NavLink v-if="$page.props.auth.user?.is_admin" :href="route('assemblies.create')" classes="text-white bg-green-700 hover:bg-green-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Nieuw
                                    </NavLink>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <!-- Odd row -->
                            <tr v-for="assembly in $page.props.assemblies.data" :key="assembly.id">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ assembly.manufacturer.name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ assembly.name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ assembly.price }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <NavLink v-if="$page.props.auth.user" :href="route('assemblies.show', assembly.id)" classes="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 ml-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Bekijk
                                    </NavLink>
                                    <NavLink v-if="$page.props.auth.user?.is_admin" :href="route('assemblies.edit', assembly.id)" classes="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 ml-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Bewerk
                                    </NavLink>
                                    <NavLink v-if="$page.props.auth.user?.is_admin" @click="destroy(assembly.id)" classes="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 ml-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Verwijder
                                    </NavLink>
                                </td>
                            </tr>
                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
