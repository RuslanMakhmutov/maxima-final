<script setup>
import {Head} from '@inertiajs/vue3';
import CommonLayout from "@/Layouts/CommonLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import PostForm from "@/Pages/Admin/Post/Partials/PostForm.vue";

const props = defineProps({
    categories: {
        type: Object,
        default: () => ({
            data: [],
        }),
    },
});
</script>

<template>
    <Head title="Создание статьи" />

    <CommonLayout>
        <template #header>
            <h2
                class="text-lg font-semibold leading-tight text-gray-800"
            >
                Создание статьи
            </h2>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <section>
                    <PostForm
                        :categories="categories.data"
                    />
                </section>
            </div>
        </div>
    </CommonLayout>
</template>
