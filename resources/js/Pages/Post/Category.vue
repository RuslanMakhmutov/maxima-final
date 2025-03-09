<script setup>
import { Head } from '@inertiajs/vue3';
import CommonLayout from "@/Layouts/CommonLayout.vue";
import PostsList from "@/Pages/Post/Partials/PostsList.vue";
import CategoriesList from "@/Pages/Post/Partials/CategoriesList.vue";
const props = defineProps({
    category: {
        type: Object,
        default: () => ({}),
    },
    posts: {
        type: Object,
        default: () => ({
            data: [],
            links: {},
            meta: {},
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
    <Head :title="category.title" />

    <CommonLayout>
        <template #header>
            <h2
                class="text-lg font-semibold leading-tight text-gray-800"
            >
                {{category.title}}
            </h2>
        </template>

        <div class="py-2 sm:py-6">
            <CategoriesList
                :categories="categories.data"
                class="hidden mb-2 sm:block"
            />
            <PostsList
                :posts="posts"
            />
            <CategoriesList
                :categories="categories.data"
                class="mt-2"
            />
        </div>
    </CommonLayout>
</template>
