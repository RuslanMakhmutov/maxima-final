<script setup>
import Pagination from "@/Components/Pagination.vue";
import PostsListItem from "@/Pages/Post/Partials/PostsListItem.vue";

const props = defineProps({
    posts: {
        type: Object,
        default: () => ({
            data: [],
            links: {},
            meta: {},
        }),
    },
})
</script>

<template>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <Pagination
            :links="posts.links"
            :meta="posts.meta"
            class="hidden sm:block"
        />

        <div class="mx-auto my-6 grid max-w-2xl grid-cols-1 gap-6 lg:mx-0 lg:max-w-none sm:grid-cols-2 lg:grid-cols-3">
            <PostsListItem
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />
        </div>

        <Pagination
            :links="posts.links"
            :meta="posts.meta"
        />
    </div>
</template>
