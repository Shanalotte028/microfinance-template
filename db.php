<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname   = "db_login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, );

// Check connection
if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error());
  }
else{
    
}

// $host = "localhost";
// $dbname = "db_login";
// $username = "root";
// $password = "";

// $mysqli = new mysqli(hostname: $host,
//                      username: $username,
//                      password: $password,
//                      database: $dbname);
                     
// if ($mysqli->connect_errno) {
//     die("Connection error: " . $mysqli->connect_error);
// }

return $conn;