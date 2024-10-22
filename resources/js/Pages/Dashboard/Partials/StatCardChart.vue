<script setup>
import { ref, onMounted, watch } from "vue";
import {
  Chart,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale,
  LineController,
  Filler,
} from "chart.js";

Chart.register(
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale,
  LineController,
  Filler
);

const props = defineProps({
  labels: { type: Array, default: () => [0, 1, 2, 3, 4, 5, 6] },
  values: { type: Array, default: () => [15, 4, 10, 2, 12, 4, 12] },
  color: String,
});

const chart = ref(null);
const canvasRef = ref(null);
const colorClassRef = ref(null);

function initChart() {
  const borderColor = window.getComputedStyle(colorClassRef.value).color;
  const backgroundColor = borderColor.replace(/[^/]+\)$/, "0.1)");

  chart.value = new Chart(canvasRef.value, {
    type: "line",
    data: {
      labels: props.labels,
      datasets: [
        {
          data: props.values,
          backgroundColor,
          borderColor,
          borderWidth: 2,
          tension: 0.5,
          fill: "start",
        },
      ],
    },
    options: {
      elements: {
        point: { radius: 0 },
      },
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
      },
      scales: {
        x: { display: false },
        y: { display: false },
      },
      tooltips: { enabled: false },
    },
  });
}

function updateChart() {
  if (chart.value) {
    chart.value.destroy();
    initChart();
  }

  //TODO: this gives an error: "Max call stack size exceeded"
  // so as a workaround, we destroy and re-create the chart
  // see above!
  //--------------------------------------------

  // chart.value.data.labels = props.labels;
  // chart.value.data.datasets[0].data = props.values;
  // chart.value.update();
}

onMounted(() => initChart());

watch(
  () => props.values,
  () => updateChart()
);
</script>

<template>
  <div class="absolute bottom-0 inset-x-0 rounded-b-2xl">
    <canvas ref="canvasRef" class="h-6">
      <span ref="colorClassRef" :class="[color, 'text-opacity-50']" />
    </canvas>
  </div>
</template>
