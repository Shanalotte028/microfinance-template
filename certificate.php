<?php
require 'db.php';

if (isset($_POST['submit'])) {
    // Retrieve user email from form submission
    $userEmail = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email already exists in the database (i.e., user has already submitted)
    $email_check_query = "SELECT * FROM certificate WHERE email = ?";
    $stmt = $conn->prepare($email_check_query);
    
    if ($stmt === false) {
        echo "<p>Error preparing the query: " . htmlspecialchars($conn->error) . "</p>";
        exit();
    }
    
    // Bind the email value to the query
    $stmt->bind_param('s', $userEmail);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // If a row is found, the user has already applied
    if ($result->num_rows > 0) {
        echo "<script>
                alert('You have already submitted the form.');
                window.location.href = 'home.php'; // Redirect back to home page
              </script>";
    } else {
        // Process the form and store the new submission
        $fName = mysqli_real_escape_string($conn, $_POST['fName']);
        $lName = mysqli_real_escape_string($conn, $_POST['lName']);
        $sex = mysqli_real_escape_string($conn, $_POST['Sex']);
        $age = mysqli_real_escape_string($conn, $_POST['Age']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);

        // Insert the form data into the database
        $insert_query = "INSERT INTO certificate (fName, lName, sex, age, email, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_query);
        
        if ($stmt_insert === false) {
            echo "<p>Error preparing the insert query: " . htmlspecialchars($conn->error) . "</p>";
            exit();
        }
        
        // Bind the form values to the insert query
        $stmt_insert->bind_param('sssiis', $fName, $lName, $sex, $age, $userEmail, $address);
        
        // Execute the insert query
        if ($stmt_insert->execute()) {
            echo "<script>
                    alert('Form submitted successfully!');
                    window.location.href = 'home.php'; // Redirect after submission
                  </script>";
        } else {
            echo "<p>Error inserting data: " . htmlspecialchars($stmt_insert->error) . "</p>";
        }
        
        // Close the insert statement
        $stmt_insert->close();
    }
    
    // Close the original statement
    $stmt->close();
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
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    </head>
<body class="sb-nav-fixed bg-dark">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4 text-light">Fill up</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="fName" name="fName" type="text" required placeholder="Enter your first name" />
                                <label for="fName">First name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="lName" name="lName" type="text" required placeholder="Enter your last name" />
                                <label for="lName">Last name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="Sex" name="Sex" type="text" required placeholder="Enter your Sex" />
                                <label for="Sex">Sex</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="Age" name="Age" type="number" required placeholder="Enter your Age" />
                                <label for="Age">Age</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" required placeholder="Enter your email" />
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="address" name="address" type="text" required placeholder="Address" />
                                <label for="address">Address</label>
                            </div>
                            <div class="mt-4 mb-0 text-center">
                                <button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="home.php" class="text-muted">Go Back</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script> 
    
</body>
</html>

      
