<?php 
session_start();
require 'db.php';

if (!empty($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $fName = $_POST["fName"];
    $lName = $_POST["lName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $reset_token_hash = $_POST["reset_token_hash"];
    $reset_token_expires_at = $_POST["reset_token_expires_at"];

    // Check if the reset token values exist in POST data, otherwise set to NULL
    $reset_token_hash = isset($_POST["reset_token_hash"]) ? $_POST["reset_token_hash"] : null;
    $reset_token_expires_at = isset($_POST["reset_token_expires_at"]) ? $_POST["reset_token_expires_at"] : null;

    // Validate input fields (basic validation, you can expand as necessary)
    if (empty($fName) || empty($lName) || empty($email) || empty($password) || empty($confirmpassword)) {
        echo "<script>alert('All fields are required!');</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
        exit();
    }

    if ($password !== $confirmpassword) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    // Check for duplicate email using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data securely with the hashed password
        $stmt = $conn->prepare("INSERT INTO users (fName, lName, email, password_hash, reset_token_hash, reset_token_expires_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fName, $lName, $email, $password_hash, $reset_token_hash, $reset_token_expires_at);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful! You will now be redirected to the login page.');
                    window.location.href = 'login.php'; // Redirect to login page
                  </script>";
        } else {
            echo "<script>alert('An error occurred during registration.');</script>";
        }
    }

    $stmt->close(); // Close the statement
}
?>




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <!-- <script src="/js/validate.js" defer></script> -->
</head>

<body class="bg-dark" style="--bs-bg-opacity: .95;">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 text-light">Create Account</h3>
                                </div>


                                <div class="card-body">
                                    <form class="" action="" method="post" id="" autocomplete="off" >
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="fName" name="fName" type="text"  required value="" placeholder="Enter your first name" />
                                                    <label for="fName">First name</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="lName" name="lName" type="text" required value="" placeholder="Enter your last name" />
                                                    <label for="lName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" name="email" type="email" required value="" placeholder="name@example.com" />
                                            <label for="email">Email address</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="password" name="password" required value="" type="password" placeholder="Create a password" />
                                                    <label for="password">Password</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password" />
                                                    <label for="confirmpassword">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                         <button type="submit" name="submit" class="btn btn-success btn-block ">Create Account</button>
                                        </div>
                                    </form>
                                </div>


                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php" class="text-muted">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
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