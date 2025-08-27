// Pie Chart: Sản lượng từng thửa đất năm 2024
var pieCtx = document.getElementById("myPieChart");
new Chart(pieCtx, {
  type: "doughnut",
  data: {
    labels: ["Thửa số 1", "Thửa số 2", "Thửa số 3"],
    datasets: [
      {
        label: "Sản lượng",
        data: [800, 1300, 600],
        backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
        hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
        borderColor: "#fff",
      },
    ],
  },
  options: {
    maintainAspectRatio: false,
    plugins: {
      tooltip: {
        callbacks: {
          label: function (context) {
            return `${context.label}: ${context.raw} kg`;
          },
        },
      },
    },
    legend: {
      display: false,
    },
  },
});
