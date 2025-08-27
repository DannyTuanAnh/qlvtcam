// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

// Biến global để lưu chart instance
var myAreaChart = null;
var currentYear = 2024; // Mặc định là 2024

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

// Function để load chart theo năm
function loadChartByYear(year) {
  var apiUrl = "../../API/bieu_do_san_luong_theo_mua.php?year=" + year;

  console.log("🔄 Loading chart for year:", year);
  console.log("📡 API URL:", apiUrl);

  $.ajax({
    url: apiUrl,
    method: "GET",
    dataType: "json",
    success: function (response) {
      console.log("🎯 Chart API Response:", response);

      if (response.success && response.data && response.data.length > 0) {
        // Tách labels và data
        var labels = response.data.map((item) => item.tenVu);
        var sanLuongData = response.data.map((item) => item.sanLuong);

        console.log("📊 Labels:", labels);
        console.log("📈 Data:", sanLuongData);

        // Destroy chart cũ nếu có
        if (myAreaChart) {
          myAreaChart.destroy();
        }

        // Tạo chart mới
        var ctx = document.getElementById("myAreaChart");
        myAreaChart = new Chart(ctx, {
          type: "line",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Sản lượng (Tấn)",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: sanLuongData,
              },
            ],
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
              },
            },
            scales: {
              xAxes: [
                {
                  time: {
                    unit: "date",
                  },
                  gridLines: {
                    display: false,
                    drawBorder: false,
                  },
                  ticks: {
                    maxTicksLimit: 7,
                  },
                },
              ],
              yAxes: [
                {
                  ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    callback: function (value, index, values) {
                      return number_format(value) + " Tấn";
                    },
                  },
                  gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2],
                  },
                },
              ],
            },
            legend: {
              display: false,
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: "#6e707e",
              titleFontSize: 14,
              borderColor: "#dddfeb",
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: "index",
              caretPadding: 10,
              callbacks: {
                label: function (tooltipItem, chart) {
                  var datasetLabel =
                    chart.datasets[tooltipItem.datasetIndex].label || "";
                  return (
                    datasetLabel +
                    ": " +
                    number_format(tooltipItem.yLabel) +
                    " Tấn"
                  );
                },
              },
            },
          },
        });

        // Cập nhật tiêu đề
        $("#selectedYear").text("(" + year + ")");

        console.log("✅ Chart created successfully for year:", year);
      } else {
        console.error("❌ No chart data available for year:", year);

        // Hiển thị chart trống
        if (myAreaChart) {
          myAreaChart.destroy();
        }

        var ctx = document.getElementById("myAreaChart");
        myAreaChart = new Chart(ctx, {
          type: "line",
          data: {
            labels: ["Không có dữ liệu"],
            datasets: [
              {
                label: "Sản lượng (Tấn)",
                data: [0],
                borderColor: "rgba(255, 99, 132, 1)",
                backgroundColor: "rgba(255, 99, 132, 0.1)",
              },
            ],
          },
          options: {
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  ticks: {
                    callback: function (value) {
                      return value + " Tấn";
                    },
                  },
                },
              ],
            },
          },
        });

        $("#selectedYear").text("(" + year + " - Không có dữ liệu)");
      }
    },
    error: function (xhr, status, error) {
      console.error("❌ AJAX Error for year", year + ":", error);
      console.error("📝 Response Text:", xhr.responseText);
    },
  });
}

// Load chart ban đầu (2024)
$(document).ready(function () {
  loadChartByYear(currentYear);

  // Event handler cho dropdown
  $(".year-selector").click(function (e) {
    e.preventDefault();
    var selectedYear = parseInt($(this).data("year"));

    console.log("🎯 Year selected:", selectedYear);

    currentYear = selectedYear;
    loadChartByYear(selectedYear);

    // Visual feedback
    $(".year-selector").removeClass("active");
    $(this).addClass("active");
  });
});
