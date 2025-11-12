<?php
    $maBuuCuc = $_SESSION['buu_cuc_info']['maBuuCuc'];
    echo "<script> var maBuuCuc = " . json_encode($maBuuCuc) . ";</script>";
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
        fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDoanhThuBC.php?maBuuCuc=' + maBuuCuc)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Kiểm tra dữ liệu trả về từ API
                
                // Tính tổng số lượng đơn hàng
                const totalSoluong = data.reduce((accumulator, currentItem) => accumulator + parseFloat(currentItem.soLuong), 0);
                console.log('Tổng số lượng đơn hàng:', totalSoluong);

                // Tạo mảng labels và chartData
                const labels = data.map(item => item.status);
                console.log('Labels:', labels);
                const chartData = data.map(item => (item.soLuong / totalSoluong) * 100); // Tính phần trăm cho mỗi loại đơn hàng
                console.log('ChartData:', chartData);

                const backgroundColors = [
                    '#1ec795', 
                    '#367dca', 
                    '#e7401a', 
                    '#ffc107', 
                    '#9be6cd'
                ];
                const borderColors = [
                    '#65e564', 
                    'rgba(54, 162, 235, 1)', 
                    'rgba(255, 99, 132, 1)', 
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ];

                const ctx = document.getElementById('myPieChart').getContext('2d');
                const myPieChart = new Chart(ctx, {
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
                                        return `${labels[tooltipItem.dataIndex]}: ${chartData[tooltipItem.dataIndex]}`;
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
                                    return context.dataset.backgroundColor[context.dataIndex] ;
                                },
                                font: {
                                    weight: 'bold',
                                    size: '20'
                                },
                                formatter: (value, ctx) => {
                                    return value.toFixed(2) + '%'; 
                                },
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

</body>
</html>
