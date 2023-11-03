// // Set new default font family and font color to mimic Bootstrap's default styling
// Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
// Chart.defaults.global.defaultFontColor = '#292b2c';

// // Bar Chart Example
// var ctx = document.getElementById("myCityChart");
// var myLineChart = new Chart(ctx, {
//   type: 'bar',
//   data: {
//     labels: _ycharge,
//     datasets: [{
//       label: "Price",
//       backgroundColor: "rgba(2,117,216,1)",
//       borderColor: "rgba(2,117,216,1)",
//       data: _xcharge,
//     }],
//   },
//   options: {
//     scales: {
//       xAxes: [{
//         time: {
//           unit: 'month'
//         },
//         gridLines: {
//           display: false
//         },
//         ticks: {
//           maxTicksLimit: 6
//         }
//       }],
//       yAxes: [{
//         ticks: {
//           min: 0,
//           max: 200,
//           minTicksLimit: 4,
//           maxTicksLimit: 9,
//         },
//         gridLines: {
//           display: true
//         }
//       }],
//     },
//     legend: {
//       display: false
//     }
//   }
// });




// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';


// Bar Chart Example
// 

var allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// Create an array for prices, matching the order of allMonths
var prices = allMonths.map(function(month) {
  // Check if the current month is in _yticket
  var index = _ycharge.indexOf(month);
  if (index !== -1) {
    // If the month is in _yticket, use the corresponding price from _xticket
    return _xcharge[index];
  } else {
    // If the month is not in _yticket, use null as a placeholder
    return null;
  }
});

// Bar Chart Example
var ctx = document.getElementById("myCityChart");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: allMonths, // Show all months on the X-axis
    datasets: [{
      label: "Price",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: prices, // Use the prices array with placeholders for missing months
    }],
  },
  options: {
    scales: {
      xAxes: [{
        type: 'category',
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 12, // Show all months
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          maxTicksLimit: 9,
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});