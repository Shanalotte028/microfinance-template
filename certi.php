<?php
session_start();
require 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}


// Assuming you store student name and email in the session
$student_id = $_SESSION['id'];
$new_name = isset($_SESSION['fName']) ? $_SESSION['fName'] : '';
$student_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Handle form submission for profile update
if (isset($_POST['submit'])) {
    $new_name = $_POST['fName'];
    $new_email = $_POST['email'];

    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $profile_pic_name = $_FILES['profile_pic']['fName'];
        $profile_pic_tmp_name = $_FILES['profile_pic']['tmp_name'];
        $profile_pic_folder = 'uploads/profile_pics/' . $profile_pic_name;

        // Move the uploaded file to the specified directory
        move_uploaded_file($profile_pic_tmp_name, $profile_pic_folder);

        // Update the profile in the database with the profile picture
        $query = "UPDATE users SET fName = ?, email = ?, profile_pic = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $new_name, $new_email, $profile_pic_folder, $student_id);
    } else {
        // If no profile picture uploaded, update the profile without changing the picture
        $query = "UPDATE users SET fName = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $new_name, $new_email, $student_id);
    }

    if ($stmt->execute()) {
        // Update session variables with the new data
        $_SESSION['student_name'] = $new_name;
        $_SESSION['email'] = $new_email;

        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }

    $stmt->close();
}

// Fetch current profile data from the database
$query = "SELECT fName, lName, email, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$profile_data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Profile Dashboard" />
    <meta name="author" content="" />
    <title>Profile Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed bg-light">

<!-- Top Navbar -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="home.php">Profile Dashboard</a>
    <ul class="navbar-nav ms-auto me-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($profile_data['fName']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Main</div>
                    <a class="nav-link" href="dashboard.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="edit_profile.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                        Edit Profile
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main content -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Profile Details</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Profile</li>
                </ol>

               <!-- Profile Display Card -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user-circle me-1"></i>
        Your Profile
    </div>
    <div class="card-body text-center">
        <div class="mb-3">
            <!-- Use the correct path for the profile picture -->
            <img src="<?php echo htmlspecialchars($profile_data['profile_pic']); ?>" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px;">
        </div>
        <h5 class="card-title"><?php echo htmlspecialchars($profile_data['fName']) . ' ' . htmlspecialchars($profile_data['lName']); ?></h5>
        <p class="card-text"><?php echo htmlspecialchars($profile_data['email']); ?></p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
    </div>
</div>



                <!-- Edit Profile Modal -->
                <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editProfileModalLabel">Update Your Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($profile_data['fName']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($profile_data['email']);
                                        
                                        ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="profile_pic" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control-file" id="profile_pic" name="profile_pic">
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 bg-dark mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Student Dashboard 2023</div>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
