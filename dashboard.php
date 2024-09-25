<?php
include('header.php');
include('footer.php');
include("security.php");
include("config.php");

if ($conn == false) {
    die("ERROR: could not connect." . mysqli_connect_error());
}

$year = date("Y");

$income_sql = "
    SELECT COALESCE(SUM(d.amount), 0) AS total_amount, MONTH(t.tDate) AS month
    FROM transactions t
    LEFT JOIN details d ON t.tNo = d.dTNo
    LEFT JOIN accountsname act ON act.accCode = t.tAccCode
    WHERE (YEAR(t.tDate) = ?)
        AND act.accName = 'Income'
        AND t.tuID = 1
    GROUP BY MONTH(t.tDate)
";

$stmt_income = mysqli_prepare($conn, $income_sql);
mysqli_stmt_bind_param($stmt_income, 'i', $year);
mysqli_stmt_execute($stmt_income);
$result_income = mysqli_stmt_get_result($stmt_income);

$income_data = [];
while ($row = mysqli_fetch_assoc($result_income)) {
    $income_data[$row['month']] = $row['total_amount'];
}

mysqli_stmt_close($stmt_income);

$expense_sql = "
    SELECT COALESCE(SUM(d.amount*-1), 0) AS total_amount, MONTH(t.tDate) AS month
    FROM transactions t
    LEFT JOIN details d ON t.tNo = d.dTNo
    LEFT JOIN accountsname act ON act.accCode = t.tAccCode
    WHERE (YEAR(t.tDate) = ?)
        AND act.accName = 'Expenses'
        AND t.tuID = 1
    GROUP BY MONTH(t.tDate)
";

$stmt_expense = mysqli_prepare($conn, $expense_sql);
mysqli_stmt_bind_param($stmt_expense, 'i', $year);
mysqli_stmt_execute($stmt_expense);
$result_expense = mysqli_stmt_get_result($stmt_expense);

$expense_data = [];
while ($row = mysqli_fetch_assoc($result_expense)) {
    $expense_data[$row['month']] = $row['total_amount'];
}

mysqli_stmt_close($stmt_expense);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Income and Expense Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 45%; 
            height: 500px;
            margin: 10px;
            float: left;
        }
    </style>
</head>
<body>

<section class="home">
    <div class="container">
      <header class="running-underline">Dashboard</header>
    </div>

<div class="chart-container">
    <canvas id="areaChart" height="500" width="500"></canvas>
</div>

<div class="chart-container">
    <canvas id="donutChart" height="500" width="500"></canvas>
</div>

<script>
 
    var incomeData = <?php echo json_encode(array_values($income_data)); ?>;
    var expenseData = <?php echo json_encode(array_values($expense_data)); ?>;
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    var areaCtx = document.getElementById('areaChart').getContext('2d');
    var areaChart = new Chart(areaCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Income',
                data: incomeData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Expenses',
                data: expenseData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Amount'
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }
        }
    }
    });

   
    var donutCtx = document.getElementById('donutChart').getContext('2d');
    var donutChart = new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Income', 'Expenses'],
            datasets: [{
                label: 'Income and Expenses',
                data: [<?php echo array_sum($income_data); ?>, <?php echo array_sum($expense_data); ?>],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Income and Expenses  in a Year'
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
</script>

</section>

</body>
</html>