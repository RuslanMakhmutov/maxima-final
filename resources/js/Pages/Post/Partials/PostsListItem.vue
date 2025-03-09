<script setup>
import {Link} from '@inertiajs/vue3';
const props = defineProps({
    post: {
        type: Object,
        default: () => ({}),
    }
})
</script>

<template>
    <article class="flex max-w-xl flex-col items-start justify-between rounded-md bg-white py-2 px-3">
        <!--<img-->
        <!--    v-if="post.image"-->
        <!--    :src="post.image" alt=""-->
        <!--    class="size-10 rounded-full bg-gray-50"-->
        <!--/>-->
        <div class="flex items-center gap-x-4 text-xs">
            <time :datetime="post.created_at" class="text-gray-500">{{ new Date(post.created_at).toLocaleDateString() }}</time>
            <Link
                :href="route('posts.category', post.category.id)"
                class="relative z-10 rounded-full bg-blue-100 px-3 py-1 font-medium text-gray-600 hover:bg-blue-200 transition"
            >{{ post.category.title }}</Link>
        </div>
        <div class="group relative">
            <h3 class="text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                <Link
                    :href="route('posts.show', post.id)"
                    :only="['post']"
                >
                    <span class="absolute inset-0"/> {{ post.title }}
                </Link>
            </h3>
            <p class="mt-1 line-clamp-3 text-sm/6 text-gray-600">{{ post.description }}</p>
        </div>
        <div class="relative mt-1 flex items-center gap-x-4">
            <div class="text-sm/6">
                <p class="font-semibold text-gray-900">
                    {{ post.user.name }}
                </p>
            </div>
        </div>
    </article>
</template>
