<?php 
session_start();
require 'db.php';

if(!empty($_SESSION["id"])){
    header("Location: index.php");
}
if(isset($_POST["submit"])){
    $fName = $_POST["fName"];
    $lName = $_POST["lName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($duplicate)> 0){
        echo "<script> alert('Email already exists!');</script>";
    }
    else{
        if($password == $confirmpassword){
            $query = "INSERT INTO users VALUES ('','$fName','$lName','$email','$password')";
            mysqli_query($conn, $query);
            echo 
            "<script>
                alert('Registration successful! You will now be redirected to the login page.');
                window.location.href = 'login.php'; // Redirect to login page
            </script>";
        }
        else{
            echo "<script> alert('Passwords do not match!');</script>";
        }
    }
}
// if(!empty($_SESSION["id"])){
//     header("Location: index.php");
// }

// if (isset($_POST["submit"])) {
//     $fName = $_POST["fName"];
//     $lName = $_POST["lName"];
//     $email = $_POST["email"];
//     $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
//     $confirmpassword = $_POST["confirmpassword"];
    
//     // Check for duplicate users with the same name and email
//     $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE fName = '$fName' AND email = '$email'"); 
    
//     if (mysqli_num_rows($duplicate) > 0) {
//         echo "<script> alert('User already exists!');</script>";
//     } else {
//         // Check if the hashed password matches the confirmation password
//         if (password_verify($confirmpassword, $password_hash)) {
//             $query = "INSERT INTO users VALUES('', '$fName', '$lName', '$email', '$password_hash', '$admin_role')";
//             mysqli_query($conn, $query);
//             echo "<script>
//                 alert('Registration successful! You will now be redirected to the login page.');
//                 window.location.href = 'login.php'; // Redirect to login page
//             </script>";
//         } else {
//             echo "<script> alert('Passwords do not match!');</script>";
//         }
//     }
// }


// require 'db.php';

// if(isset($_POST["submit"])){
//     $fName = $_POST["fName"];
//     $lName = $_POST["lName"];
//     $email = $_POST["email"];
//     $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
//     $confirmpassword = $_POST["confirmpassword"];
//     $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE fName = '$fName' AND email = '$email'"); 
//     if(mysqli_num_rows($duplicate) >0){
//         echo 
//         "<script> alert('User already exists!');</script>";
      
//     }  
//     else{
//         if($password_hash == $confirmpassword){
//             $query = "INSERT INTO users VALUES('', '$fName', '$lName','$email','$passowrd_hash')";
//             mysqli_query($conn, $query);
//             echo
//             "<script>
//             alert('Registration successful! You will now be redirected to the login page.');
//             window.location.href = 'login.html'; // Redirect to login page
//         </script>";
//         }
//         else{
//             echo
//             "<script> alert('Passwords do not match!');</script>";
//         }
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