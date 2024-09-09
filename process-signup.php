<?php

if (empty($_POST["name"])) {
    die("Name is required");
}

if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 5) {
    die("Password must be at least 5 characters");
}

if (! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["confirmpassword"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/db.php";

$sql = "INSERT INTO users (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sss",
    $_POST["name"],
    $_POST["email"],
    $password_hash
);




if ($stmt->execute()) {

header("Location: index.html");
exit;

} else {

    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
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
