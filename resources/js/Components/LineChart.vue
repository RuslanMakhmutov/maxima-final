<script setup>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js';
import { Line } from 'vue-chartjs';
import { ref } from 'vue';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);

const props = defineProps({
    statistics: {
        type: Object,
        required: true
    },
    options: {
        type: Object,
        default: () => ({
            responsive: true,
            maintainAspectRatio: true
        })
    }
});

const data = ref({
    labels: Object.keys(props.statistics),
    datasets: [
        {
            label: 'Просмотры',
            data: Object.values(props.statistics).map(({ visits }) => visits),
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgb(255, 99, 132)'
        },
        {
            label: 'Комментарии',
            data: Object.values(props.statistics).map(({ comments }) => comments),
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgb(54, 162, 235)'
        }
    ]
});
</script>

<template>
    <Line :data="data" :options="options" />
</template>
