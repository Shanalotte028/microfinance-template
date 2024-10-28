<?php
session_start();
require 'db.php';  // Your database connection

// Ensure the user is logged in and is an instructor
if (!isset($_SESSION['id']) || $_SESSION['role'] != 3) {
    echo "You are not authorized to view requests.";
    exit();
}

$instructor_id = $_SESSION['id'];  // Get instructor ID from session

// Fetch the instructor's first and last name
$name_query = "SELECT fName, lName FROM users WHERE id = ?";
$stmt_name = $conn->prepare($name_query);
$stmt_name->bind_param("i", $instructor_id);
$stmt_name->execute();
$result_name = $stmt_name->get_result();

if ($result_name->num_rows > 0) {
    $instructor = $result_name->fetch_assoc();
    $instructor_name = $instructor['fName'] . ' ' . $instructor['lName'];  // Concatenate first and last name
} else {
    $instructor_name = 'Unknown';  // Fallback in case the instructor is not found
}
$stmt_name->close();

// Fetch unread messages count
$unread_query = "SELECT COUNT(*) as unread_count FROM feedback WHERE instructor_id = ? AND status = 'unread'";
$stmt_unread = $conn->prepare($unread_query);
$stmt_unread->bind_param("i", $instructor_id);
$stmt_unread->execute();
$result_unread = $stmt_unread->get_result();
$unread_count = $result_unread->fetch_assoc()['unread_count'];
$stmt_unread->close();

// Fetch messages for the instructor
$query = "
    SELECT feedback.id, feedback.message, feedback.date_sent, users.fName, users.lName, feedback.status
    FROM feedback
    JOIN users ON feedback.employee_id = users.id
    WHERE feedback.instructor_id = ? 
    ORDER BY feedback.date_sent DESC";  // Show newest messages first
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();

// Mark message as read when clicked
if (isset($_GET['read_id'])) {
    $message_id = $_GET['read_id'];
    $update_query = "UPDATE feedback SET status = 'read' WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $message_id);
    $update_stmt->execute();
    $update_stmt->close();
    header("Location: instructor.php");  // Refresh the page after marking as read
    exit();
}

// Delete message
if (isset($_GET['delete_id'])) {
    $message_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM feedback WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $message_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    header("Location: instructor.php");  // Refresh the page after deleting
    exit();
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
    <title>Dashboard - Instructor</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Microfinance</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <span class="text-white">Unread Messages: <?= $unread_count ?></span>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                    <!-- Add more menu items here as needed -->
                </div>
            </div>
            <div class="sb-sidenav-footer bg-dark">
                <div class="small">Logged in as:</div>
                <!-- Display the instructor's name here -->
                <strong><?php echo htmlspecialchars($instructor_name); ?></strong>
            </div>
        </nav>
    </div>


        <div id="layoutSidenav_content" class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="container">
                        <h2 class="text-light mt-5">Requests</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Message</th>
                                    <th>Date Sent</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $status_display = $row['status'] == 'unread' ? "<strong>(Unread)</strong>" : "(Read)";
                                        echo "<tr>
                                                <td>{$row['fName']} {$row['lName']}</td>
                                                <td>{$row['message']}</td>
                                                <td>{$row['date_sent']}</td>
                                                <td>$status_display</td>
                                                <td>
                                                    <a href='instructor.php?read_id={$row['id']}' class='btn btn-sm btn-success'>Mark as Read</a>
                                                    <a href='instructor.php?delete_id={$row['id']}' class='btn btn-sm btn-danger'>Delete</a>
                                                </td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No requests found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto bg-dark">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#" class="text-muted">Privacy Policy</a>
                            &middot;
                            <a href="#" class="text-muted">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
