<?php
session_start();
require 'db.php';

if(!empty($_SESSION["id"])){
    header("Location: index.php");
} 


if(isset($_POST["submit"])){    
    $email = $_POST["email"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' ");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)> 0){
        if($password == $row["password"]){
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["id"];
        header("Location: index.php");
    }
    else{
        echo "<script>alert('Wrong email or password!');</script>";
    }
}
else{
    echo 
    "<script>alert('User not registered!');</script>";
    }
}

// if (isset($_POST["id"])) {
//     $email = $_POST["email"];
//     $password = $_POST["password"];
//     $rememberMe = isset($_POST["rememberMe"]); // Check if the "Remember Me" checkbox is selected

//     // Use prepared statements to prevent SQL injection
//     $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();

//         // Verify the password
//         if (password_verify($password, $row["password_hash"])) {
//             $_SESSION["login"] = true;
//             $_SESSION["id"] = $row["id"];

//             // If "Remember Me" is checked, set a persistent cookie for 30 days
//             if ($rememberMe) {
//                 $cookieValue = base64_encode($row["id"]); // Or generate a secure token
//                 setcookie("rememberMe", $cookieValue, time() + (86400 * 30), "/"); // Cookie expires in 30 days
//             }

//             header("Location: index.php");
//             exit;
//         } else {
//             echo "<script>alert('Wrong password!');</script>";
//         }
//     } else {
//         echo "<script>alert('User not registered!');</script>";
//     }
    
//     $stmt->close();
// }

// // Check if "rememberMe" cookie exists and auto-login
// if (isset($_COOKIE["rememberMe"])) {
//     $userId = base64_decode($_COOKIE["rememberMe"]);
//     // Query the database for the user by ID
//     $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
//     $stmt->bind_param("i", $userId);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $_SESSION["login"] = true;
//         $_SESSION["id"] = $row["id"];
//         header("Location: index.php");
//         exit;
//     }
//     $stmt->close();
// }


// if (!empty($_SESSION["id"])) {
//     header("Location: index.php");
// }

    // session_start();
 
    // if(isset($_SESSION['login'])){
    //     header("Location: index.php");
    //     exit;
    // }


// if (isset($_POST["submit"])) {
//     $email = $_POST["email"];
//     $password = $_POST["password"];
   

//     // Use prepared statements to prevent SQL injection
//     $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
//     $stmt->bind_param("s", $email); 
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();

      

//         // Ensure the column name is correct and match it with your database
//         if (isset($row["password_hash"]) && password_verify($password, $row["password_hash"])) {
//             $_SESSION["login"] = true;
//             $_SESSION["id"] = $row["id"];
//             header("Location: index.php");
//         } else {
//             echo "<script>alert('Wrong password!');</script>";
//         }
//     } else {
//         echo "<script>alert('User not registered!');</script>";
//     }
// }



?>





<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
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
                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="rememberMe" value="" />
                        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small text-muted" href="password.html">Forgot Password?</a>
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
