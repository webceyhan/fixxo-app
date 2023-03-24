<script setup>
import { ref, computed, onMounted, watch } from "vue";
import {
  Chart,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale,
  LineController,
} from "chart.js";

Chart.register(LineElement, PointElement, LinearScale, CategoryScale, LineController);

const props = defineProps({
  labels: Array,
  values: Array,
});

const canvasRef = ref(null);
const chartInstance = ref(null);

const data = computed(() => ({
  labels: props.labels,
  datasets: [
    {
      data: props.values,
      backgroundColor: "#dc3545",
      borderColor: "#dc3545",
      tension: 0.5,
    },
  ],
}));

const drawChart = () => {
  if (chartInstance.value) {
    chartInstance.value.destroy();
  }

  chartInstance.value = new Chart(canvasRef.value, {
    type: "line",
    data: data.value,
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        y: {
          ticks: {
            maxTicksLimit: 5,
            callback: (value, index, ticks) => `€${value}`,
          },
        },
      },
    },
  });
};

onMounted(() => drawChart());

// re-render chart when data changes
watch(data, () => drawChart());
</script>

<template>
  <canvas ref="canvasRef" class="w-full max-h-48"  />
</template>
