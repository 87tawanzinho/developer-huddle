<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>

<template>
    <ElButton>
        <slot />
    </ElButton>
</template>
