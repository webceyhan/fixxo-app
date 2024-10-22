<script setup lang="ts">
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

const props = defineProps<{
  labels: string[]; // TODO: define type
  values: number[]; // TODO: define type
  color: string; // TODO: define Color type
}>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
const colorClassRef = ref<HTMLSpanElement | null>(null);
const chart = ref<Chart | null>(null);

function initChart() {
  const borderColor = window.getComputedStyle(colorClassRef.value!).color;
  const backgroundColor = borderColor.replace(/[^/]+\)$/, "0.1)");

  chart.value = new Chart(canvasRef.value!, {
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
