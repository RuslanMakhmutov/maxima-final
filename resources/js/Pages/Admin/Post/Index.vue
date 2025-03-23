<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import CommonLayout from "@/Layouts/CommonLayout.vue";
import {onBeforeUnmount} from "vue";

const props = defineProps({
    posts: {
        type: Object,
        default: () => ({
            data: [],
            links: {},
            meta: {},
        }),
    },
    only_trashed: {
        type: Boolean,
        default: false
    }
});

const setupListeners = () => {
    Echo.private(`posts`)
        // .listen('PostVisitEvent', ({post_id, visits_count}) => {
        .listen('PostVisitEvent', ({ post_id }) => {
            const index = props.posts.data.findIndex(el => el.id === post_id)
            if (index !== -1) {
                props.posts.data[index].visits_count++
            }
        })
        .listen('CommentStoredEvent', (comment) => {
            const index = props.posts.data.findIndex(el => el.id === comment.post_id)
            if (index !== -1) {
                props.posts.data[index].comments_count++
            }
        })
}

const deleteListeners = () => {
    Echo.leaveChannel(`posts`);
}

setupListeners()

onBeforeUnmount(() => {
    deleteListeners();
})
</script>

<template>
    <Head title="Статьи" />

    <CommonLayout>
        <template #header>
            <h2
                class="text-lg font-semibold leading-tight text-gray-800"
            >
                Управление статьями
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-3 sm:px-6 lg:px-8">

                <nav class="flex">
                    <Link
                        :href="posts.links.first ? route('admin.posts.index', {'page': 1, 'only_trashed': only_trashed}) : ''"
                        :only="['posts']"
                        class="text-blue-500 hover:text-blue-400 px-2 mr-3 text-xl"
                        :class="{'text-gray-300 pointer-events-none': !posts.links.first || posts.meta.current_page === 1}"
                    >
                        &laquo;
                    </Link>
                    <Link
                        :href="posts.links.prev ? route('admin.posts.index', {'page': posts.meta.current_page - 1, 'only_trashed': only_trashed}) : ''"
                        :only="['posts']"
                        class="text-blue-500 hover:text-blue-400 px-2 mr-3 text-xl"
                        :class="{'text-gray-300 pointer-events-none': !posts.links.prev}"
                    >
                        &lsaquo;
                    </Link>
                    <Link
                        :href="posts.links.next ? route('admin.posts.index', {'page': posts.meta.current_page + 1, 'only_trashed': only_trashed}) : ''"
                        :only="['posts']"
                        class="text-blue-500 hover:text-blue-400 px-2 mr-3 text-xl"
                        :class="{'text-gray-300 pointer-events-none': !posts.links.next}"
                    >
                        &rsaquo;
                    </Link>
                    <Link
                        :href="posts.links.last ? route('admin.posts.index', {'page': posts.meta.last_page, 'only_trashed': only_trashed}) : ''"
                        :only="['posts']"
                        class="text-blue-500 hover:text-blue-400 px-2 mr-3 text-xl"
                        :class="{'text-gray-300 pointer-events-none': !posts.links.last || posts.meta.current_page === posts.meta.last_page}"
                    >
                        &raquo;
                    </Link>

                    <Link
                        v-if="only_trashed"
                        :href="route('admin.posts.index')"
                        class="text-blue-500 hover:text-blue-400 px-2 ml-auto text-xl"
                    >
                        Выйти из корзины
                    </Link>
                    <Link
                        v-else
                        :href="route('admin.posts.index', {'only_trashed': 1})"
                        class="text-blue-500 hover:text-blue-400 px-2 ml-auto text-xl"
                    >
                        Корзина
                    </Link>
                </nav>

                <table class="border-collapse border border-gray-300 w-full bg-white">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 p-2">ID</th>
                            <th class="border border-gray-300 p-2">Заголовок</th>
                            <th class="border border-gray-300 max-w-20"></th>
                            <th class="border border-gray-300 max-w-20"></th>
                            <th class="border border-gray-300 p-2">Категории</th>
                            <th class="border border-gray-300 p-2">Создано</th>
                            <th class="border border-gray-300 p-2">Опублик.</th>
                            <th class="border border-gray-300 p-2">Стат.</th>
                            <th class="border border-gray-300 p-2 w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in posts.data" :key="post.id">
                            <td class="border border-gray-300 p-2 text-right">
                                <Link
                                    :href="route('admin.posts.edit', post.id)"
                                    :only="['post', 'categories']"
                                    class="text-blue-600 dark:text-blue-500 hover:underline"
                                >
                                    {{ post.id }}
                                </Link>
                            </td>
                            <td class="border border-gray-300 p-2">
                                <Link
                                    :href="route('admin.posts.edit', post.id)"
                                    class="text-blue-600 dark:text-blue-500 hover:underline"
                                >
                                    {{ post.title }}
                                </Link>
                            </td>
                            <td class="border border-gray-300 align-middle">
                                <a :href="post.image_url" target="_blank">
                                    <img class="max-w-20 max-h-10 text-xs" :src="post.image_url">
                                </a>
                            </td>
                            <td class="border border-gray-300 align-middle">
                                <Link
                                    :href="route('posts.show', post.id)"
                                    :only="['post']"
                                    class="font-mono text-lg text-blue-600 dark:text-blue-500 inline-block"
                                    target="_blank"
                                >
                                    открыть
                                </Link>
                            </td>
                            <td class="border border-gray-300 p-2">
                                <small>
                                    <template v-for="category in post.categories" :key="category.id">
                                        <component
                                            :is="category.id === post.category_id ? 'strong' : 'div'"
                                            class="whitespace-nowrap"
                                        >
                                            {{ category.title }} ({{category.id}})
                                        </component>
                                    </template>
                                </small>
                            </td>
                            <td class="border border-gray-300 p-2">
                                {{ new Date(post.created_at).toLocaleDateString() }}<br>
                                {{ new Date(post.created_at).toLocaleTimeString() }}
                            </td>
                            <td class="border border-gray-300 p-2">
                                <template v-if="post.published_at">
                                    {{ new Date(post.published_at).toLocaleDateString() }}<br>
                                    {{ new Date(post.published_at).toLocaleTimeString() }}
                                </template>
                            </td>
                            <td class="border border-gray-300 px-2">
                                <div title="Просмотров" class="cursor-default whitespace-nowrap">
                                    <span class="font-mono text-lg text-orange-500 inline-block">&#x1F441;</span>
                                    {{ post.visits_count }}
                                </div>
                                <div title="Комментариев" class="cursor-default whitespace-nowrap">
                                    <span class="font-mono text-lg text-orange-500 inline-block">&#9998;</span>
                                    {{ post.comments_count }}
                                </div>
                            </td>
                            <td class="border border-gray-300 p-1">
                                <div v-if="only_trashed" class="flex flex-nowrap space-x-2">
                                    <Link
                                        :href="route('admin.posts.restore', post.id)"
                                        method="put"
                                        as="button"
                                        class="p-1 font-bold text-lg text-green-600 hover:text-green-400"
                                        title="Восстановить из корзины"
                                    >
                                        <span class="inline-block">&#8634;</span>
                                    </Link>
                                    <Link
                                        :href="route('admin.posts.destroy', post.id)"
                                        method="delete"
                                        as="button"
                                        class="p-1 font-mono text-lg text-red-600 hover:text-red-400"
                                        title="Удалить навсегда"
                                    >
                                        <span class="inline-block">&#x2716;</span>
                                    </Link>
                                </div>
                                <div v-else class="flex flex-nowrap space-x-2">
                                    <Link
                                        :href="route('admin.posts.edit', post.id)"
                                        class="p-1 font-mono text-lg text-blue-500 hover:text-blue-300"
                                        title="Редактировать"
                                    >
                                        <span class="-scale-x-100 inline-block">&#9998;</span>
                                    </Link>
                                    <Link
                                        :href="route('admin.posts.delete', post.id)"
                                        method="delete"
                                        as="button"
                                        class="p-1 font-mono text-lg text-red-500 hover:text-red-300"
                                        title="Удалить в корзину"
                                    >
                                        <span class="inline-block">&#x2716;</span>
                                    </Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <Link
                        :href="route('admin.posts.add')"
                        :only="['categories']"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    >
                        Добавить статью
                    </Link>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
