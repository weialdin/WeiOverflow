<script setup>
import TagsItem from "./TagsItem.vue";

defineProps({
    tags: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <ul class="tags-inline">
        <TagsItem v-for="tag in tags" :key="tag" :tag="tag" />
    </ul>
</template>
