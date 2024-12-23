<script setup>
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
</script>

<template>
    <Link :href="'/'">
        <template>
   <Icon icon="openmoji:cat" />
        </template>
    </Link>
</template>
