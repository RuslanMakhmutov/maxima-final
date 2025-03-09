<script setup>
import {Head} from '@inertiajs/vue3';
import CommonLayout from "@/Layouts/CommonLayout.vue";
import CategoriesList from "@/Pages/Post/Partials/CategoriesList.vue";
import PostCard from "@/Pages/Post/Partials/PostCard.vue";
import Comments from "@/Pages/Post/Partials/Comment/Comments.vue";

const props = defineProps({
    post: {
        type: Object,
        default: () => ({
            data: {},
        }),
    },
    comments: {
        type: Object,
        default: () => ({
            data: [],
        }),
    },
    categories: {
        type: Object,
        default: () => ({
            data: [],
        }),
    }
})
</script>

<template>
    <Head :title="post.data.title"/>

    <CommonLayout>
        <template #header>
            <h1 class="text-lg font-semibold leading-tight text-gray-800">{{ post.data.title }}</h1>
        </template>

        <div class="py-2 sm:py-6">
            <CategoriesList
                :categories="categories.data"
                class="hidden mb-2 sm:block"
                :active_id="post.data.category_id"
            />

            <PostCard :post="post.data" />

            <Comments
                :comments="comments.data"
                :post="post.data"
                class="mt-4"
            />

            <CategoriesList
                :categories="categories.data"
                class="mt-2"
                :active_id="post.data.category_id"
            />
        </div>
    </CommonLayout>
</template>
