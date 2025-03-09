<script setup>
defineProps({
    continents: {
        type: Array,
    }
});
</script>

<template>
    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-6">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900 mb-2">
                    Список континентов, полученный по SOAP
                </h2>
            </header>
            <ul>
                <li
                    v-for="continent in continents"
                    :key="continent.sCode"
                >
                    {{ continent.sName }}
                </li>
            </ul>
        </section>
    </div>
</template>
