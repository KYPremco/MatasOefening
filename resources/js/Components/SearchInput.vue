<script setup>
// source: https://adambailey.io/blog/jetstream-search-input/
import {ref, watch} from "vue";
import _ from "lodash";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    routeName: String || URL
});

const search = ref(Inertia.page.props.search || null);

watch([search], ([newSearch], []) => {
    if (search.value.length > 0) {
        searchMethod(newSearch);
    } else {
        Inertia.get(props.routeName, {}, { preserveState: true });
    }
});

const searchMethod = _.debounce((searchInput) => {
    Inertia.get(props.routeName, { search: searchInput }, { preserveState: true })
}, 500);

</script>

<template>
        <label for="search" class="hidden">Search</label>
        <input
            id="search"
            ref="searchRef"
            v-model="search"
            class="transition h-10 w-full bg-gray-100 border border-gray-500 rounded-full focus:border-purple-400 outline-none cursor-pointer text-gray-700 px-4 pb-0 pt-px"
            :class="{ 'transition-border': search }"
            autocomplete="off"
            name="search"
            placeholder="Zoeken..."
            type="search"
        />
</template>
