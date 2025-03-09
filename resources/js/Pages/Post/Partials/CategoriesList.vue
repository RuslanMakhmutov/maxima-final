<script setup>
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    categories: {
        type: Array,
        default: () => ([]),
    },
    active_id: {
        type: Number,
        default: 0
    },
})

</script>

<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <nav class="border-b border-gray-100 bg-white flex flex-col sm:flex-row">
            <NavLink
                v-for="cat in categories"
                :key="cat.id"
                :href="route('posts.category', cat.id)"
                :active="cat.id === active_id || route().current('posts.category', cat.id)"
                class="px-4 py-2 pt-2"
            >{{cat.title}}</NavLink>
        </nav>
    </div>
</template>
