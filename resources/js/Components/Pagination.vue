<script setup>
import {computed} from 'vue';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    routeName: {
        type: String,
        required: false,
    },
    meta: {
        type: Object,
        default: () => ({})
    },
    links: {
        type: Object,
        default: () => ({})
    },
});
</script>

<template>
    <div class="flex items-center justify-between bg-white rounded-md px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link
                :href="links.prev || ''"
                :only="['posts']"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                :class="{'!text-gray-300 pointer-events-none': !links.prev}"
            >
                <span class="sr-only">Предыдущая</span>
                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"></path>
                </svg>
            </Link>
            <!--<a href="#"-->
            <!--&gt;Пред.</a>-->
            <!--<a href="#"-->
            <!--   class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"-->
            <!--&gt;След.</a>-->

            <Link
                :href="links.next || ''"
                :only="['posts']"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                :class="{'!text-gray-300 pointer-events-none': !links.next}"
            >
                <span class="sr-only">Следующая</span>
                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                </svg>
            </Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Показаны с
                    <span class="font-medium">{{ meta.from }}</span>
                    по
                    <span class="font-medium">{{ meta.to }}</span>
                    из
                    <span class="font-medium">{{ meta.total }}</span>
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <Link
                        :href="links.prev || ''"
                        :only="['posts']"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                        :class="{'!text-gray-300 pointer-events-none': !links.prev}"
                    >
                        <span class="sr-only">Предыдущая</span>
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"></path>
                        </svg>
                    </Link>

                    <template
                        v-for="(link, key) in meta.links"
                        :key="key"
                    >
                        <component
                            v-if="key !== 0 && key !== meta.links.length - 1"
                            :is="link.url ? Link : 'span'"
                            :href="link.label === '1' ? meta.path : link.url"
                            :class="[
                                {'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': link.url && link.active},
                                {'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0': link.url && !link.active},
                                {'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0': !link.url},
                                {'pointer-events-none': link.active}
                            ]"
                            :aria-current="link.active ? 'page' : undefined"
                            v-html="link.label"
                            :only="['posts']"
                        />
                    </template>

                    <Link
                        :href="links.next || ''"
                        :only="['posts']"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                        :class="{'!text-gray-300 pointer-events-none': !links.next}"
                    >
                        <span class="sr-only">Следующая</span>
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                        </svg>
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>
