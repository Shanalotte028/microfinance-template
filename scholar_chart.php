<?php

session_start();
require 'db.php'; // Ensure your database connection is successful

// Check if user is logged in and is an admin
if (!isset($_SESSION["id"]) || $_SESSION["role"] != 1) {
    header("Location: login.php");
    exit();
}
// Fetch the ages from the database
$query = "SELECT Age FROM images_coe_birthc";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully and has results
if ($result) {
    $ages = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $ages[] = $row['Age'];
    }
} else {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed bg-dark">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="home.php">Microfinance</a>
        <!-- User Dropdown -->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item text-muted" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link" href="scholar_app.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Scholarship applications
                        </a>
                        <a class="nav-link" href="job_app.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Job applications
                        </a>
                        <a class="nav-link" href="tesda_app.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Tesda applications
                        </a>


                        <div class="sb-sidenav-menu-heading">  Charts </div>
                        <a class="nav-link" href="scholar_chart.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                           Scholarship Charts
                        </a>
                        <a class="nav-link" href="job_chart.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                           Job Charts
                        </a>
                        <a class="nav-link" href="tesda_chart.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                         Tesda Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer bg-dark">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Charts</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php" class="text-light">Dashboard</a></li>
                        <li class="breadcrumb-item active">Charts</li>
                    </ol>
                   
  <div class="row">
                    <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-area me-1"></i>
        Scholarship Applicants Age Chart
    </div>

    <canvas id="myAreaChart" width="60%" height="10"></canvas>

    <script>
        // Debugging output for ages
        console.log(<?php echo json_encode($ages); ?>); // Check output in console

        var ages = <?php echo json_encode($ages); ?>;

        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({
                    length: ages.length
                }, (_, i) => `Applicant ${i + 1}`),
                datasets: [{
                    label: "Age",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    data: ages,
                }],
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Applicants'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Age'
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1, // Ensure the y-axis increments by 1
                            callback: function(value) {
                                if (value % 1 === 0) {
                                    return value; // Display only whole numbers
                                }
                            }
                        }
                    }
                }
            }
        });
    </script>

    <div class="card-body">
        <canvas id="myAreaChart" width="60%" height="10"></canvas>
    </div>
</div>


                    <!-- Bar and Pie Chart (Optional) -->
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Bar Chart Example
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Pie Chart Example
                                </div>
                                <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        
        </div>
    </div>

    <!-- Chart.js Rendering for the Area Chart -->
    <script>
        // Get the ages data from PHP
        var ages = <?php echo json_encode($ages); ?>;

        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({
                    length: ages.length
                }, (_, i) => `Applicant ${i + 1}`), // Labels for applicants
                datasets: [{
                    label: "Age",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: ages, // Use the ages data
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'applicant'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: ages.length // Set ticks limit based on number of applicants
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: Math.min(...ages) - 5, // Adjust the Y axis min value dynamically
                            max: Math.max(...ages) + 5, // Adjust the Y axis max value dynamically
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <!-- Bootstrap Bundle and Other Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
       
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="assets/demo/chart-pie-demo.js"></script>
</body>

</html>