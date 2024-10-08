<?php
session_start();
require 'db.php';

// Redirect if user is already logged in
if (!empty($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];  // Store plain password

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if user exists
    if ($row) {
        // Verify the hashed password with the entered plain password
        if (password_verify($password, $row["password_hash"])) {
            // Set session variables
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["role"] = $row["role"]; // Fetch the role from the DB
            
            // Role-based redirection
            if ($row["role"] == 1) {  // Admin role
                echo "<script>
                alert('You are logged in as Admin');
                window.location.href = 'index.php'; // Redirect to Admin dashboard
                </script>";
            } elseif ($row["role"] == 0) {  // Regular user role
                echo "<script>
                alert('Welcome, User!');
                window.location.href = 'home.php'; // Redirect to user home
                </script>";
            }
            exit(); // Ensure no further code is executed
        } else {
            // Invalid password
            echo "<script>alert('Wrong email or password!');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not registered!');</script>";
    }
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
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
<body class="bg-dark" style="--bs-bg-opacity: .95;">
<div id="layoutAuthentication">
<div id="layoutAuthentication_content">
<main>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
            <div class="card-header"><h3 class="text-center font-weight-muted my-4 text-light">Login</h3></div>
            <div class="card-body">

                <form class="" action="" method="post" id="" autocomplete="off">
                    
                    <div class="form-floating mb-3">
                        <input class="form-control text-dark" id="email" name="email" type="text"  
                             required value=""  placeholder="Email"/>
                        <label for="email">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control text-dark" id="password" name="password" type="password"  required value="" placeholder="Password" />
                        <label for="password">Password</label>
                    </div>
                    <div class="form-check mb-3 text-muted">
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small text-muted" href="password.php">Forgot Password?</a>
                        <!-- <a class="btn btn-success" href="index.php">Login</a> -->
                        <button class="btn btn-success" type="submit" name="submit" id="login">Login</button>

                    </div>
                    
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small text-"><a href="register.php" class="text-muted">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-dark mt-auto">
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
