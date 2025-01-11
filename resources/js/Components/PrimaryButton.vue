<script setup>
import { ElButton } from "element-plus";

defineProps({
    type: {
        type: String,
        default: "submit",
    },
});
</script>

<template>
    <button
        type="primary"
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-60 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
