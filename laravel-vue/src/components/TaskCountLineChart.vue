<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  props: ["data"],
  mounted() {
    console.log(`data=`, this.data);
    const labels = [...Array(60).keys()];
    const max = Math.max(...this.data) + 5;
    console.log(`data=${this.data.length}, max=${max}`);

    this.renderChart(
      {
        labels: labels,
        datasets: [
          {
            label: "Count",
            data: this.data,
            backgroundColor: "transparent",
            borderColor: "rgba(1, 116, 188, 0.50)",
            pointBackgroundColor: "rgba(171, 71, 188, 1)",
          },
        ],
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [
            {
              display: true,
              ticks: {
                max: max,
                suggestedMin: 0, // minimum will be 0, unless there is a lower value.
              },
            },
          ],
        },
        title: {
          display: true,
          text: "Uncompleted task count in last one hour",
        },
      }
    );
  },
};
</script>
