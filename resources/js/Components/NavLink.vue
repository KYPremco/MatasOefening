<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'classes']);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
