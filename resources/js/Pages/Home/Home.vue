<script setup>
import { Head } from '@inertiajs/vue3';
import CommonLayout from "@/Layouts/CommonLayout.vue";
import Pollutions from "@/Pages/Home/Partials/Pollutions.vue";
import Continents from "@/Pages/Home/Partials/Continents.vue";

defineProps({
    pollution: {
        type: Object,
    },
    continents: {
        type: Array,
    },
    points: {
        type: Array,
    }
});
</script>

<template>
    <Head title="Новостной блог" />

    <CommonLayout>
        <template #header>
            <h2
                class="text-lg font-semibold leading-tight text-gray-800"
            >
                Главная
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex flex-col sm:flex-row gap-4 sm:gap-6 sm:flex-wrap">
                <Pollutions
                    :pollution="pollution"
                    class="grow"
                />
                <Continents
                    :continents="continents"
                    class="flex-auto"
                />
            </div>
        </div>
    </CommonLayout>
</template>
