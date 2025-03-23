<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import DropdownTrigger from "@/Components/DropdownTrigger.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="border-b border-gray-100 bg-white"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-12 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link
                                    :href="route('home')"
                                    class="flex items-center"
                                >
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 mr-2"
                                    />

                                    Новостной блог
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center"
                            >
                                <NavLink
                                    :href="route('home')"
                                    :active="route().current('home')"
                                >
                                    Главная
                                </NavLink>

                                <NavLink
                                    :href="route('posts.index')"
                                    :active="route().current('posts.*')"
                                >
                                    Статьи
                                </NavLink>

                                <Dropdown v-if="$page.props.auth.isAdmin">
                                    <template #trigger>
                                        <DropdownTrigger title="Админка"/>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('admin.posts.index')"
                                            :active="route().current('admin.posts.*')"
                                        >
                                            Статьи
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('admin.categories.index')"
                                            :active="route().current('admin.categories.*')"
                                        >
                                            Категории
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('admin.statistics.index')"
                                            :active="route().current('admin.statistics.*')"
                                        >
                                            Статистика
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown v-if="$page.props.auth.user" align="right" width="48">
                                    <template #trigger>
                                        <DropdownTrigger :title="$page.props.auth.user.name"/>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Профиль
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Выйти
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                                <nav v-else class="-mx-3 flex flex-1 justify-end">
                                    <Link
                                        :href="route('login')"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Вход
                                    </Link>

                                    <Link
                                        :href="route('register')"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Регистрация
                                    </Link>
                                </nav>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('home')"
                            :active="route().current('home')"
                        >
                            Главная
                        </ResponsiveNavLink>

                        <ResponsiveNavLink
                            :href="route('posts.index')"
                            :active="route().current('posts.*')"
                        >
                            Статьи
                        </ResponsiveNavLink>

                    </div>

                    <!-- Admin Navigation Menu -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <template v-if="$page.props.auth.isAdmin">
                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('admin.posts.index')"
                                    :active="route().current('admin.posts.*')"
                                >
                                    Управление статьями
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('admin.categories.index')"
                                    :active="route().current('admin.categories.*')"
                                >
                                    Управление категориями
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('admin.statistics.index')"
                                    :active="route().current('admin.statistics.*')"
                                >
                                    Статистика
                                </ResponsiveNavLink>
                            </div>
                        </template>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <template v-if="$page.props.auth.user">
                            <div class="px-4">
                                <div
                                    class="text-base font-medium text-gray-800"
                                >
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink :href="route('profile.edit')">
                                    Профиль
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Выйти
                                </ResponsiveNavLink>
                            </div>
                        </template>
                        <nav v-else class="flex flex-col">
                            <ResponsiveNavLink :href="route('login')">
                                Вход
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('register')">
                                Регистрация
                            </ResponsiveNavLink>
                        </nav>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
