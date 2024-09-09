<?php



$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/db.php";

$sql = "INSERT INTO users (fName, lName, email, password_hash)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "ssss",
    $_POST["fName"],
    $_POST["lName"],
    $_POST["email"],
    $password_hash
);



if ($stmt->execute()) {

header("Location: login-success.html");

            
}

// // Check if email exists
// $query = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
// $query->bind_param('s', $email);
// $query->execute();
// $query->bind_result($count);
// $query->fetch();
// $query->close();

// if ($count == 0) {
//     // Email does not exist, proceed with insert
//     $query = $mysqli->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
//     $query->bind_param('ss', $email, $password_hash);
//     $query->execute();
//     $query->close();
// } else {
//     // Handle the case where email already exists
//     echo "Email already exists.";
// }














// try {
//   // Example SQL statement that might cause a duplicate entry error
//   $stmt = $mysqli->prepare("INSERT INTO users (email) VALUES (?)");
//   $email = 'ken@email.com';
//   $stmt->bind_param("s", $email);
//   $stmt->execute();
// } catch (mysqli_sql_exception $e) {
//   // Get error number and message
//   $errno = $e->getCode(); // This gives the MySQL error number
//   $errorMessage = $e->getMessage(); // This gives the MySQL error message

//   echo "Error Number: $errno\n";
//   echo "Error Message: $errorMessage\n";
// }

// $stmt->close();
// $mysqli->close();
