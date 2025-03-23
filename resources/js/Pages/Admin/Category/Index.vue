<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import CommonLayout from "@/Layouts/CommonLayout.vue";
import {onBeforeUnmount} from "vue";

const props = defineProps({
    categories: {
        type: Object,
        default: () => ({
            data: [],
            links: {},
            meta: {},
        }),
    }
});

const setupListeners = () => {
    Echo.private(`categories`)
        .listen('CategoryVisitEvent', ({ category_id }) => {
            const index = props.categories.data.findIndex(el => el.id === category_id)
            if (index !== -1) {
                props.categories.data[index].visits_count++
            }
        })
}

const deleteListeners = () => {
    Echo.leaveChannel(`categories`);
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

                <table class="border-collapse border border-gray-300 w-full bg-white">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 p-2">ID</th>
                            <th class="border border-gray-300 p-2">Заголовок</th>
                            <th class="border border-gray-300 max-w-20"></th>
                            <th class="border border-gray-300 p-2">Создано</th>
                            <th class="border border-gray-300 p-2">Стат.</th>
                            <th class="border border-gray-300 p-2 w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories.data" :key="category.id">
                            <td class="border border-gray-300 p-2 text-right">
                                <Link
                                    :href="route('admin.categories.edit', category.id)"
                                    :only="['category']"
                                    class="text-blue-600 dark:text-blue-500 hover:underline"
                                >
                                    {{ category.id }}
                                </Link>
                            </td>
                            <td class="border border-gray-300 p-2">
                                <Link
                                    :href="route('admin.categories.edit', category.id)"
                                    class="text-blue-600 dark:text-blue-500 hover:underline"
                                >
                                    {{ category.title }}
                                </Link>
                            </td>
                            <td class="border border-gray-300 align-middle">
                                <Link
                                    :href="route('posts.category', category.id)"
                                    class="font-mono text-lg text-blue-600 dark:text-blue-500 inline-block"
                                    target="_blank"
                                >
                                    открыть
                                </Link>
                            </td>
                            <td class="border border-gray-300 p-2">
                                {{ new Date(category.created_at).toLocaleDateString() }}
                                {{ new Date(category.created_at).toLocaleTimeString() }}
                            </td>
                            <td class="border border-gray-300 px-2">
                                <div title="Просмотров" class="cursor-default whitespace-nowrap">
                                    <span class="font-mono text-lg text-orange-500 inline-block">&#x1F441;</span>
                                    {{ category.visits_count }}
                                </div>
                            </td>
                            <td class="border border-gray-300 p-1">
                                <div class="flex flex-nowrap space-x-2">
                                    <Link
                                        :href="route('admin.categories.edit', category.id)"
                                        class="p-1 font-mono text-lg text-blue-500 hover:text-blue-300"
                                        title="Редактировать"
                                    >
                                        <span class="-scale-x-100 inline-block">&#9998;</span>
                                    </Link>
                                    <Link
                                        :href="route('admin.categories.destroy', category.id)"
                                        method="delete"
                                        as="button"
                                        class="p-1 font-mono text-lg text-red-500 hover:text-red-300"
                                        title="Удалить"
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
                        :href="route('admin.categories.create')"
                        :only="['categories']"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    >
                        Добавить категорию
                    </Link>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
