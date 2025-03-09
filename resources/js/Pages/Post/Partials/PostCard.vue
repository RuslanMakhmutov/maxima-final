<script setup>

import {Link} from "@inertiajs/vue3";

const props = defineProps({
    post: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 text-gray-900 overflow-hidden">
                <div class="flex items-center gap-x-4 text-xs mb-2">
                    <time :datetime="post.created_at" class="text-gray-500">
                        {{ new Date(post.created_at).toLocaleDateString()}}
                    </time>
                    <Link
                        v-for="category in post.categories"
                        :key="category.id"
                        :href="route('posts.category', category.id)"
                        class="relative z-10 rounded-full bg-blue-100 px-3 py-1 font-medium text-gray-600 hover:bg-blue-200 transition"
                        :class="{'text-gray-700 bg-blue-200 hover:bg-blue-300': category.id === post.category_id}"
                    >{{ category.title }}</Link>
                </div>

                <div v-if="post.image">
                    <img
                        :src="post.image"
                        :alt="post.title"
                        width="200"
                        class="float-right ml-4 mb-2 max-w-36 sm:max-w-full shadow-md"
                    >
                </div>

                <div class="text">
                    <p
                        v-for="(p, key) in post.content.split(/[\r\n]+/)"
                        :key="key"
                        class="mb-3"
                    >{{ p }}</p>
                </div>

                <div class="relative mt-8 flex items-center gap-x-4">
                    <div class="text-sm/6">
                        <p class="font-semibold text-gray-900">
                            {{ post.user.name }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
