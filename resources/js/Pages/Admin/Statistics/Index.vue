<script setup>
import { Head } from '@inertiajs/vue3';
import CommonLayout from '@/Layouts/CommonLayout.vue';
import { ref } from 'vue';
import LineChart from '@/Components/LineChart.vue';
import BarChart from '@/Components/BarChart.vue';

const props = defineProps({
    day: {
        type: Object,
        required: true,
    },
    week: {
        type: Object,
        required: true,
    },
    month: {
        type: Object,
        required: true,
    }
});

const tabs = ref([
    {
        name: 'day',
        title: 'День'
    },
    {
        name: 'week',
        title: 'Неделя'
    },
    {
        name: 'month',
        title: 'Месяц'
    }
]);

const activeTab = ref('month');
</script>

<template>
    <Head title="Статистика" />

    <CommonLayout>
        <template #header>
            <h2 class="text-lg font-semibold leading-tight text-gray-800">Статистика просмотров и комментариев</h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-3 sm:px-6 lg:px-8">
                <div class="flex">
                    <button
                        v-for="tab in tabs"
                        :key="tab.name"
                        class="border border-gray-200 px-4 py-2 text-sm font-medium"
                        :class="[
                            { 'bg-blue-700 text-white': tab.name === activeTab },
                            { 'bg-gray-100 text-gray-900': tab.name !== activeTab }
                        ]"
                        @click="activeTab = tab.name"
                    >
                        {{ tab.title }}
                    </button>
                </div>

                <div v-for="tab in tabs" :key="tab.name">
                    <div v-if="tab.name === activeTab" class="flex flex-wrap gap-8">
                        <div class="flex-auto">
                            <h2 class="mb-4 text-xl">Итого</h2>
                            <table
                                class="border-collapse border border-gray-400 bg-white text-sm dark:border-gray-500 dark:bg-gray-800"
                            >
                                <tbody>
                                    <tr>
                                        <td
                                            class="border border-gray-300 p-4 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                                        >
                                            Просмотры
                                        </td>
                                        <td
                                            class="border border-gray-300 p-4 text-right text-gray-500 dark:border-gray-700 dark:text-gray-400"
                                        >
                                            {{ Object.values(props[tab.name]).reduce((acc, el) => acc + el.visits, 0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="border border-gray-300 p-4 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                                        >
                                            Комментарии
                                        </td>
                                        <td
                                            class="border border-gray-300 p-4 text-right text-gray-500 dark:border-gray-700 dark:text-gray-400"
                                        >
                                            {{ Object.values(props[tab.name]).reduce((acc, el) => acc + el.comments, 0) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex-grow">
                            <div class="m-auto max-w-3xl">
                            <BarChart v-if="tab.name === 'day'" :statistics="props[tab.name]" />
                            <LineChart v-else :statistics="props[tab.name]" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
