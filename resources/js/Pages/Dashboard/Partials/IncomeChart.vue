<script setup>
import { ref, onMounted, watch } from "vue";
import {
  Chart,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale,
  LineController,
} from "chart.js";

Chart.register(LineElement, PointElement, LinearScale, CategoryScale, LineController);

/**
 * Colors:
 *
 * text-info
 * text-success
 * text-warning
 * text-error
 */
const props = defineProps({
  labels: Array,
  values: Array,
  color: String,
});

const canvasRef = ref(null);
const chartInstance = ref(null);
const colorClassRef = ref(null);

const drawChart = () => {
  if (chartInstance.value) {
    chartInstance.value.destroy();
  }

  const borderColor = window.getComputedStyle(colorClassRef.value).color;
  const backgroundColor = borderColor.replace(/[^/]+\)$/, "0.05)");

  chartInstance.value = new Chart(canvasRef.value, {
    type: "line",
    data: {
      labels: props.labels,
      datasets: [
        {
          data: props.values,
          backgroundColor,
          borderColor,
          tension: 0.5,
          fill: "start",
        },
      ],
    },
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
watch(
  () => props.values,
  () => drawChart()
);
</script>

<template>
  <canvas ref="canvasRef" class="w-full max-h-48">
    <span ref="colorClassRef" :class="`text-${color} text-opacity-50`" />
  </canvas>
</template>
