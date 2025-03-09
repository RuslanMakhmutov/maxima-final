<script setup>
defineProps({
    points: {
        type: Array,
    }
});
</script>

<template>
    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-6">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900 mb-2">
                    Список точек (первые 10), располагающихся не дальше чем 0.01 от точки (0.5, 0.5), в порядке возрастания расстояния
                </h2>
            </header>

            <table class="border-collapse border border-gray-300 w-full bg-white">
                <thead>
                <tr>
                    <th class="border border-gray-300 p-2">ID</th>
                    <th class="border border-gray-300 p-2">Точка</th>
                    <th class="border border-gray-300 p-2">Расстояние</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="point in points" :key="point.id">
                    <td class="border border-gray-300 p-2 text-right">
                        {{ point.id }}
                    </td>
                    <td class="border border-gray-300 p-2 text-right">
                        {{ point.pos }}
                    </td>
                    <td class="border border-gray-300 p-2 text-right">
                        {{ point.distance }}
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</template>
