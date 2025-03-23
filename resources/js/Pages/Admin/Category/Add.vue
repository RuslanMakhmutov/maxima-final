<script setup>
import { Head } from '@inertiajs/vue3';
import CommonLayout from '@/Layouts/CommonLayout.vue';
import CategoryForm from '@/Pages/Admin/Category/Partials/CategoryForm.vue';
</script>

<template>
    <Head title="Создание категории" />

    <CommonLayout>
        <template #header>
            <h2 class="text-lg font-semibold leading-tight text-gray-800">Создание категории</h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <section>
                    <CategoryForm />
                </section>
            </div>
        </div>
    </CommonLayout>
</template>
