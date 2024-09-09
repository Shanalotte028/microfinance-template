<?php
// require 'db.php';
// if(!empty($_SESSION["id"])){
//     header("Location: index.php");
// }


$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $mysqli = require __DIR__ . "/db.php";

  $sql = sprintf(
    "SELECT * FROM users
                    WHERE email = '%s'",
    $mysqli->real_escape_string($_POST["email"])
  );

  $result = $mysqli->query($sql);

  $users = $result->fetch_assoc();

  if ($users) {

    if (password_verify($_POST["password"], $users["password_hash"])) {

      session_start();

      session_regenerate_id();

      $_SESSION["user_id"] = $users["id"];

      header("Location: index.html");
      exit;
    }
  }

  $is_invalid = true;
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

                                        <form class="" action="" method="post" autocomplete="off"><?php if ($is_invalid): ?>
                                            <em>Invalid login</em>
                                            <div class="form-floating mb-3">
                                                 <label for="email"></label>
                                                 <?php endif; ?>
                                                <input class="form-control text-dark" id="email" type="email" name="email" placeholder="name@example.com" />
                                                value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control text-dark" id="password" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>



                                            </div>
                                            <div class="form-check mb-3 text-muted">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small text-muted" href="password.html">Forgot Password?</a>
                                                <a class="btn btn-success" href="index.html">Login</a>
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
