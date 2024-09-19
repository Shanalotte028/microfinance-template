<?php 

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$conn = require __DIR__ . "/db.php";

$sql = "SELECT * FROM users
    WHERE reset_token_hash = ?";
  
$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user == null) {
  echo  "<script>
alert('Token not found');
window.location.href = 'reset-password.php'; // Redirect to login page
</script>";
}
if(strtotime($user["reset_token_expires_at"]) <= time()){
  echo  "<script>
  alert('Token was expired');
  window.location.href = 'password.php'; // Redirect to login page
  </script>";
}

$sql = "UPDATE users 
      SET password = ?,
      reset_token_hash = NULL,
      reset_token_expires_at = NULL
      WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $password, $user["id"]);

$stmt->execute();

echo  "<script>
alert('Password updated.');
window.location.href = 'login.php'; // Redirect to login page
</script>";