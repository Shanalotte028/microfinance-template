<!-- <?php 

?> -->


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tables - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-success" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
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
                           
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer bg-dark">
                        <div class="small ">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content" class="bg-dark" style="--bs-bg-opacity: .95;">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-light">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php" class="text-light">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div>
                        <!-- <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Uploaded Documents DataTable
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Age</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Certificate of Enrollment</th>
                                            <th>Birth Certificate</th>
                                            <th>Status</th>
                                            <th>Date Uploaded</th>
                                            <th>Date Status Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Age</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Certificate of Enrollment</th>
                                            <th>Birth Certificate</th>
                                            <th>Status</th>
                                            <th>Date Uploaded</th>
                                            <th>Date Status Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        // Fetch data from the `images_coe_birthc` table
                                        $query = "SELECT * FROM images_coe_birthc";
                                        $result = mysqli_query($conn, $query);
                        
                                        // Handle Approve/Decline/Delete requests
                                        if (isset($_POST['action']) && isset($_POST['id'])) {
                                            $id = $_POST['id'];
                                            $action = $_POST['action'];
                        
                                            if ($action == 'approve') {
                                                // Update the status to 'Approved' and set the date_status_updated
                                                $update_query = "UPDATE images_coe_birthc SET status = 'Approved', date_status_updated = NOW() WHERE id = ?";
                                            } elseif ($action == 'decline') {
                                                // Update the status to 'Declined' and set the date_status_updated
                                                $update_query = "UPDATE images_coe_birthc SET status = 'Declined', date_status_updated = NOW() WHERE id = ?";
                                            }
                        
                                            // Prepare and execute the update query for approval or decline
                                            if (isset($update_query)) {
                                                $stmt = $conn->prepare($update_query);
                                                $stmt->bind_param('i', $id); // Bind the ID
                                                if ($stmt->execute()) {
                                                    echo  "<script>
                                                        alert('Record updated successfully');
                                                        window.location.href = 'index.php'; // Redirect to index page
                                                        </script>";
                                                } else {
                                                    echo "Error updating record: " . mysqli_error($conn);
                                                }
                                            }
                                        }
                        
                                        // Fetch and display the records
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['fName']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['lName']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['Age']); ?></td> <!-- Display Age -->
                                                    <td><?php echo htmlspecialchars($row['email']); ?></td> <!-- Display Email -->
                                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                                    <td>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="images-coe-birthc/<?php echo htmlspecialchars($row['coe']); ?>">
                                                            <img src="images-coe-birthc/<?php echo htmlspecialchars($row['coe']); ?>" alt="COE" style="width: 100px;">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="images-coe-birthc/<?php echo htmlspecialchars($row['birthc']); ?>">
                                                            <img src="images-coe-birthc/<?php echo htmlspecialchars($row['birthc']); ?>" alt="Birth Certificate" style="width: 100px;">
                                                        </a>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['date_uploaded']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['date_status_updated']); ?></td>
                                                    <td>
                                                        <form method="POST" action="">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            <?php if ($row['status'] == 'Pending') { ?>
                                                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                                                <button type="submit" name="action" value="decline" class="btn btn-danger btn-sm">Decline</button>
                                                            <?php } elseif ($row['status'] == 'Approved' || $row['status'] == 'Declined') { ?>
                                                                <button type="submit" name="action" value="remove" class="btn btn-warning btn-sm">Remove</button>
                                                            <?php } ?>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='12'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Modal for image display -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="modalImage" src="" alt="Document Image" style="max-width: 100%; height: auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var datatablesSimple = document.getElementById('datatablesSimple');
                                if (datatablesSimple) {
                                    new simpleDatatables.DataTable(datatablesSimple);
                                }
                        
                                // Modal image display
                                var imageModal = document.getElementById('imageModal');
                                imageModal.addEventListener('show.bs.modal', function (event) {
                                    var button = event.relatedTarget;  // Button that triggered the modal
                                    var imageUrl = button.getAttribute('data-image');  // Extract image URL from data-* attributes
                                    var modalImage = document.getElementById('modalImage');  // Get the image element inside the modal
                                    modalImage.src = imageUrl;  // Set the source of the image in the modal
                                });
                            });
                        </script> -->
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
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
