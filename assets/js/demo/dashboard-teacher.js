$(document).ready(function() {
    $.ajax({
        url: 'index.php?controller=api&action=teacher',
        method: 'GET',
        success: function(response) {
            // Set values to the corresponding elements
            $('#totalApproved').text(response.totalApproved);
            $('#totalPending').text(response.totalPending);
            $('#totalRejected').text(response.totalRejected);
            $('#totalSuccess').text(response.totalSuccess);

            // Data for Pie Chart
            var pieData = [response.totalSuccess, response.totalRejected];

            // Create Pie Chart
            var ctxPie = document.getElementById("myPieChart").getContext('2d');
            var myPieChart = new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ["Thành công", "Từ chối"],
                    datasets: [{
                        data: pieData,
                        backgroundColor: ['#1cc88a', '#e74a3b'],
                        hoverBackgroundColor: ['#17a673', '#e74a3b'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                },
            });

            // Data for Area Chart
            var labels = response.Class.map(c => c.className);
            var data = response.Class.map(c => c.studentCount);

            // Create Area Chart
            var ctxArea = document.getElementById("myAreaChart").getContext('2d');
            var myLineChart = new Chart(ctxArea, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Số lượng sinh viên",
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
                        data: data,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: labels.length
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                callback: function(value) {
                                    return value;
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleFontColor: '#6e707e',
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    }
                }
            });
        }
    });
});
