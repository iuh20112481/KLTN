<?php
    // Kiểm tra quyền và lấy mã bưu cục
    $isAdmin = isset($_SESSION['admin']) ? true : false;
    $maBuuCuc = 'all';

    if (!$isAdmin && isset($_SESSION['buu_cuc_info']) && isset($_SESSION['buu_cuc_info']['maBuuCuc'])) {
        $maBuuCuc = $_SESSION['buu_cuc_info']['maBuuCuc'];
    }
    echo "<script> var maBuuCucChart = " . json_encode($maBuuCuc) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tỷ lệ đơn hàng</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
        <canvas id="myPieChart" class="p-2"></canvas>

    <script>
        // Lưu trữ instance của chart để có thể cập nhật
        let myPieChart = null;

        // Function để tạo hoặc cập nhật biểu đồ
        function updatePieChart(maBuuCuc) {
            fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDoanhThuBC.php?maBuuCuc=' + maBuuCuc)
                .then(response => response.json())
                .then(data => {
                    console.log('Chart data:', data);

                    // Tính tổng số lượng đơn hàng
                    const totalSoluong = data.reduce((accumulator, currentItem) => accumulator + parseFloat(currentItem.soLuong), 0);
                    console.log('Tổng số lượng đơn hàng:', totalSoluong);

                    // Tạo mảng labels và chartData
                    const labels = data.map(item => item.status);
                    const chartData = data.map(item => totalSoluong > 0 ? (item.soLuong / totalSoluong) * 100 : 0);

                    const backgroundColors = [
                        '#1ec795',
                        '#367dca',
                        '#e7401a',
                        '#ffc107'
                    ];

                    const ctx = document.getElementById('myPieChart').getContext('2d');

                    // Nếu chart đã tồn tại, destroy nó trước khi tạo mới
                    if (myPieChart) {
                        myPieChart.destroy();
                    }

                    // Tạo chart mới
                    myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: chartData,
                                backgroundColor: backgroundColors,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `${labels[tooltipItem.dataIndex]}: ${chartData[tooltipItem.dataIndex].toFixed(2)}%`;
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#fff',
                                    anchor: 'end',
                                    align: 'start',
                                    padding: 15,
                                    offset: 50,
                                    borderWidth: -60,
                                    backgroundColor: (context) => {
                                        return context.dataset.backgroundColor[context.dataIndex];
                                    },
                                    font: {
                                        weight: 'bold',
                                        size: '20'
                                    },
                                    formatter: (value, ctx) => {
                                        // Ẩn label nếu giá trị = 0
                                        if (value === 0 || value < 0.01) {
                                            return '';
                                        }
                                        return value.toFixed(2) + '%';
                                    },
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        // Load chart lần đầu với mã bưu cục mặc định
        updatePieChart(maBuuCucChart);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

</body>
</html>
