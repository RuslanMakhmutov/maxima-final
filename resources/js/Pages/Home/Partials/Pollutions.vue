<script setup>
defineProps({
    pollution: {
        type: Object,
        default: () => ({}),
    },
});

const aqi = {
    1: { title: 'Хороший', class: 'text-green-400' },
    2: { title: 'Нормальный', class: 'text-lime-500' },
    3: { title: 'Удовлетворительный', class: 'text-amber-400' },
    4: { title: 'Плохой', class: 'text-orange-500' },
    5: { title: 'Очень плохой!', class: 'text-red-600' },
};
</script>

<template>
    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-6">
        <section>
            <header>
                <h2 v-if="pollution" class="mb-2 text-lg font-medium text-gray-900">
                    Информация о качестве воздуха в Вашем городе на {{ new Date(pollution.dt * 1000).toLocaleString()
                    }}<br />
                </h2>
                <h2 v-else class="text-md mb-2 font-medium text-gray-700">
                    Настройте город в ЛК для получения информации о качестве воздуха
                </h2>
            </header>
            <template v-if="pollution">
                <p class="text-sky-500">
                    Координаты: широта {{ pollution.coord.lat }}, долгота {{ pollution.coord.lon }}
                </p>
                <p>
                    Индекс качества воздуха:
                    <span :class="aqi[pollution.main.aqi].class">{{ aqi[pollution.main.aqi].title }}</span>
                </p>
                <p>
                    Окись азота: <span>{{ pollution.components.no2 }}</span>
                </p>
                <p>
                    Озон: <span>{{ pollution.components.o3 }}</span>
                </p>
                <p>
                    Диоксид серы: <span>{{ pollution.components.so2 }}</span>
                </p>
                <p>
                    PM2.5: <span>{{ pollution.components.pm2_5 }}</span>
                </p>
                <p>
                    PM10: <span>{{ pollution.components.pm10 }}</span>
                </p>
            </template>
            <footer class="mt-3">
                <p class="text-right text-sm text-gray-500">
                    Запросы к сервису openweathermap кешируются на 60 секунд.<br />
                    Результаты сохраняются в mongoDB.<br />
                    <span
                        v-if="$page.props.auth.user && !pollution"
                        class="text-red-600"
                    >
                        Не забудьте прописать OPENWEATHERMAP_API_KEY в .env
                    </span>
                </p>
            </footer>
        </section>
    </div>
</template>
