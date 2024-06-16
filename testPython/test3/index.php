<?php
    // Run the Python script
    $output = shell_exec('python3 testSARIMA.py');
    // Include the generated PHP data file
    include 'data.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <div id="container" style="width: 100%; height: 400px;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const actualData = <?php echo json_encode($actual_data); ?>;
            const predictedData = <?php echo json_encode($predicted_data); ?>;
            Highcharts.chart('container', {
                title: {
                    text: 'Reservations Over Time'
                },
                xAxis: {
                    type: 'datetime',
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Reservations'
                    }
                },
                series: [{
                    name: 'Actual Reservations',
                    data: actualData
                }, {
                    name: 'Predicted Reservations',
                    data: predictedData
                }]
            });
        });
    </script>
</body>
</html>
