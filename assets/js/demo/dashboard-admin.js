$(document).ready(function() {
    $.ajax({
        url: 'index.php?controller=api&action=admin',
        method: 'GET',
        success: function(response) {
            if (!response) {
                console.error("Không nhận được dữ liệu hợp lệ từ API.");
                return;
            }

            // Kiểm tra dữ liệu hợp lệ trước khi gán vào HTML
            $('#totalLeader').text(response.totalLeader || 0);
            $('#totalManager').text(response.totalManager || 0);
            $('#totalSpecialist').text(response.totalSpecialist || 0);
            $('#totalTeacher').text(response.totalTeacher || 0);
            $('#totalStudent').text(response.totalStudent || 0);

            // Dữ liệu biểu đồ hình tròn
            var pieData = [
                response.totalLeader || 0,
                response.totalManager || 0,
                response.totalSpecialist || 0,
                response.totalTeacher || 0,
                response.totalStudent || 0
            ];

            // Tạo Pie Chart
            var ctxPie = document.getElementById("myPieChart").getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ["Tổng số lãnh đạo phòng đào tạo", "Tổng số lãnh đạo khoa", "Tổng số chuyên viên đào tạo", "Tổng số giáo viên", "Tổng số sinh viên"],
                    datasets: [{
                        data: pieData,
                        backgroundColor: ['#36b9cc', '#1d72b8', '#1cc88a', '#f6c23e', '#e74a3b'],
                        hoverBackgroundColor: ['#2c9faf', '#155a8a', '#17a673', '#dda20a', '#be2617'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: false },
                    cutoutPercentage: 80,
                },
            });

            // Dữ liệu biểu đồ đường theo từng năm
            var years = response.totalStudentByYear ? response.totalStudentByYear.map(y => y.year) : [];
            var studentCounts = response.totalStudentByYear ? response.totalStudentByYear.map(y => y.count) : [];

            // Tạo Line Chart (Số lượng sinh viên qua từng năm)
            var ctxLine = document.getElementById("myAreaChart").getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: years,
                    datasets: [{
                        label: "Số lượng sinh viên qua từng năm",
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
                        data: studentCounts,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        xAxes: [{
                            gridLines: { display: false, drawBorder: false },
                            ticks: { maxTicksLimit: years.length }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                callback: function(value) { return value + " sinh viên"; }
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
                    legend: { display: false },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel + " sinh viên";
                            }
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Lỗi khi tải dữ liệu từ API: ", error);
            alert("Không thể tải dữ liệu từ server. Vui lòng thử lại sau.");
        }
    });
});
