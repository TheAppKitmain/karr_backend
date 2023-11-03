// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var data = _xsummary; 

var categories = ["tolls", "charges", "tickets"];
var allMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var monthlySummary = {};

// Initialize monthlySummary
categories.forEach(function (category) {
  monthlySummary[category] = Array(12).fill(0);
});

// Fill in the monthly data
categories.forEach(function (category) {
  for (var month in data[category]) {
    var monthIndex = allMonths.indexOf(month);
    if (monthIndex !== -1) {
      monthlySummary[category][monthIndex] = data[category][month];
    }
  }
});

// Create an array of colors for the line chart datasets
var lineChartColors = ["#007bff", "#dc3545", "#ffc107"];

// Create a line chart
var ctx = document.getElementById("summaryChart");
var datasets = categories.map(function (category, index) {
  return {
    label: category,
    borderColor: lineChartColors[index],
    fill: false,
    data: monthlySummary[category],
  };
});

var myLineChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: allMonths,
    datasets: datasets,
  },
  options: {
    title: {
      display: true,
      text: 'Monthly Summary',
      fontSize: 16,
    },
    scales: {
      xAxes: [{
        type: 'category',
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true,
        },
      }],
    },
  },
});
