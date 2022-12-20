<template>
  <Bar
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
      ref="bar"
  />

</template>

<script>

import { Bar } from 'vue-chartjs'
import axios from "axios";
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)


export default {
  name: "ChartsHR",
  components: {Bar},
  data:  () => ({
    chartData: {
      labels: ['-'],
      datasets: [{
        label: 'HR',
        data: ['-'],
        borderWidth: 1,
        borderColor: '#777',
        hoverBorderWidth: 3,
        hoverBorderColor: 'DarkGreen',
      }]
    },
    matType: null,
    patientId: null,
    fromDay: null,
    fromHour: null,
    toHour: null,
    toDay: null,
    chartOptions: {
      plugins: {
        title: {
          display: true,
          text: 'Zmiany wartości rytmu serca w czasie',
          color: 'White',
          font: {
            family: 'Times',
            size: 30,
            style: 'normal',
            lineHeight: 1.2
          },
        },
        legend: {
          display: false,
      },
      },
      responsive: true,
      scales: {
        x: {
          ticks: {
            color: 'white',
            font: {
              family: 'Times',
              size: 20,
              style: 'normal',
              lineHeight: 1.2
            },
          },
          display: true,
          title: {
            display: true,
            text: 'Wartość rytmu serca',
            color: 'white',
            font: {
              family: 'Times',
              size: 25,
              style: 'normal',
              lineHeight: 1.2
            },
            padding: {top: 10, left: 0, right: 0, bottom: 10}
          }
        },
        y: {
          ticks: {
            color: 'white',
            font: {
              family: 'Times',
              size: 20,
              style: 'normal',
              lineHeight: 1.2
            },
          },
          display: true,
          title: {
            display: true,
            text: 'Przedział czasu',
            color: 'white',
            font: {
              family: 'Times',
              size: 25,
              style: 'normal',
              lineHeight: 1.2
            },
            padding: {top: 10, left: 0, right: 0, bottom: 10}
          }
        }
      }
    }
  }),
  methods: {
    async showChart() {
      try {
        //CHART
        const responseChartHR = await axios.get(
          'http://localhost:8000/hr/chart/' + this.matType,
          { params: {
              patientId: this.patientId,
              from: this.fromDay + " " + this.toHour,
              to: this.toDay + " " + this.fromHour,
            }}
        );

        // this.chartData = {
        //   labels: responseChartHR.data.map(DataTime),
        //   datasets: [{
        //     label: 'HR',
        //     data: responseChartHR.data.map(DataHR),
        //     backgroundColor: 'Khaki',
        //     borderWidth: 1,
        //     borderColor: '#777',
        //     hoverBorderWidth: 3,
        //     hoverBorderColor: 'DarkGreen',
        //   }]
        // }
        console.log(this.chartData);

        function DataHR(value) {
          return  value['hr']
        }
        function DataTime(value) {
          return  value['time']
        }
      }
      catch (error) {
        console.log(error);
      }
    },
    handleMatInput(value) {
      this.matType = value
    },
    handlePatientIdInput(value) {
      this.patientId = value
    },
    handleFromDayInput(value) {
      this.fromDay = value
    },
    handleFromHourInput(value) {
      this.fromHour = value
    },
    handleToDayInput(value) {
      this.toDay = value
    },
    handleToHourInput(value) {
      this.toHour = value
    },
  },
}
</script>

<style scoped>

</style>